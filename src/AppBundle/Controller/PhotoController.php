<?php

namespace AppBundle\Controller;

use AppBundle\Form\PhotoType;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Photo;
use AppBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhotoController extends FOSRestController
{
    /**
     * Returns filtered list of photos.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Rest\View
     */
    public function getPhotosAction(Request $request)
    {
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $photos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Photo')->findBy([], null, $limit, $offset);

        $result = [];

        foreach ($photos as &$photo) {
            $tags = [];
            foreach ($photo->getTags() as &$tag) {
                $tags[] = [
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                ];
            }

            $result[] = [
                'id' => $photo->getId(),
                'title' => $photo->getTitle(),
                'link' => $photo->getLink(),
                'tags' => $tags,
            ];
        }

        return $result;
    }

    /**
     * Returns all photos by tag name.
     *
     * @param Request $request
     *
     * @return array
     *
     * @Rest\View
     */
    public function getPhotosTagAction(Request $request)
    {
        $tagName = $request->get('tag');
        $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->findOneBy(['name' => $tagName]);

        if ($tag instanceof Tag) {
            $result = [];

            foreach ($tag->getPhotos() as &$photo) {
                $tags = [];
                foreach ($photo->getTags() as &$tag) {
                    $tags[] = [
                        'id' => $tag->getId(),
                        'name' => $tag->getName(),
                    ];
                }

                $result[] = [
                    'id' => $photo->getId(),
                    'title' => $photo->getTitle(),
                    'link' => $photo->getLink(),
                    'tags' => $tags,
                ];
            }

            return $result;
        }
    }

    /**
     * Returns photos count.
     *
     * @param Request $request
     *
     * @return mixed
     *
     * @Rest\View
     */
    public function getPhotosCountAction(Request $request)
    {
        return intval($this->getDoctrine()->getManager()->getRepository('AppBundle:Photo')->count());
    }

    /**
     * Return single photo by id.
     *
     * @param $id
     *
     * @return array
     *
     * @Rest\View
     */
    public function getPhotoAction($id)
    {
        $photo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Photo')->find($id);

        if ($photo instanceof Photo) {
            $tags = [];
            $tagsString = '';

            foreach ($photo->getTags() as &$tag) {
                $tags[] = [
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                ];
            }

            return [
                'id' => $photo->getId(),
                'title' => $photo->getTitle(),
                'link' => $photo->getLink(),
                'tags' => $tags,
                'tagString' => implode(',', array_column($tags, 'name')),
            ];
        }
        throw new NotFoundHttpException();
    }

    /**
     * Creates photo.
     *
     * @param Request $request
     *
     * @return Photo|mixed|\Symfony\Component\Form\FormErrorIterator
     *
     * @Rest\View
     */
    public function postPhotoAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);

        $form->handleRequest($request);

        $tags = $request->request->get('tags');

        if ($form->isValid()) {
            $data = $form->getData();
            $photo = $data;

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            if (!empty($tags)) {
                $tags = explode(',', $tags);
                $em->getRepository('AppBundle:Tag')->addTagsToPhoto($photo, $tags);
                $em->flush();
            }

            return $photo;
        } else {
            return $form->getErrors();
        }
    }

    /**
     * Uploads photo and save link.
     *
     * @param Request $request
     *
     * @Rest\View
     */
    public function postPhotoUploadAction(Request $request)
    {
        $photoId = $request->request->get('photoId');
        $photo = $this->getDoctrine()->getRepository('AppBundle:Photo')->find($photoId);
        $file = $request->files->get('file');
        $fileName = $photoId.'.'.$file->guessExtension();

        $file->move('uploads', $fileName);

        $photo->setLink('uploads/'.$fileName);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
    }

    /**
     * Updates photo tags.
     *
     * @param Request $request
     *
     * @Rest\View
     */
    public function putPhotoTagsAction(Request $request)
    {
        $photoId = $request->request->get('id');
        $tags = $request->request->get('tags', '');

        $photo = $this->getDoctrine()->getRepository('AppBundle:Photo')->find($photoId);
        $em = $this->getDoctrine()->getManager();
        $tags = explode(',', $tags);
        $em->getRepository('AppBundle:Tag')->addTagsToPhoto($photo, $tags);
        $em->flush();
    }

    /**
     * Delete photo.
     *
     * @param $id
     * @param Request $request
     *
     * @Rest\View
     */
    public function deletePhotoAction($id, Request $request)
    {
        $photo = $this->getDoctrine()->getRepository('AppBundle:Photo')->find($id);
        $em = $this->getDoctrine()->getManager();
        $photo->removeTags();
        $em->remove($photo);
        $em->flush();
    }
}
