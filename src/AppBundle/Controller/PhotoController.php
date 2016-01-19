<?php

namespace AppBundle\Controller;

use AppBundle\Form\PhotoType;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Photo;
use AppBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class PhotoController extends FOSRestController
{
    /**
     * @Rest\View
     */
    public function getPhotosAction()
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Photo')->findAll();
    }

    /**
     * @Rest\View
     */
    public function getPhotoAction($id)
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Photo')->find($id);
    }

    /**
     * @Rest\View
     */
    public function postPhotoAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $photo = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
            return $photo;
        } else
            return $form->getErrors();
    }
}