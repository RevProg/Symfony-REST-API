<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        if (0 === strpos($pathinfo, '/photo')) {
            if (0 === strpos($pathinfo, '/photos')) {
                // get_photos
                if (preg_match('#^/photos(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_photos;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_photos')), array (  '_controller' => 'AppBundle\\Controller\\PhotoController::getPhotosAction',  '_format' => 'json',));
                }
                not_get_photos:

                // get_photos_tag
                if (0 === strpos($pathinfo, '/photos/tag') && preg_match('#^/photos/tag(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_photos_tag;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_photos_tag')), array (  '_controller' => 'AppBundle\\Controller\\PhotoController::getPhotosTagAction',  '_format' => 'json',));
                }
                not_get_photos_tag:

                // get_photos_count
                if (0 === strpos($pathinfo, '/photos/count') && preg_match('#^/photos/count(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_photos_count;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_photos_count')), array (  '_controller' => 'AppBundle\\Controller\\PhotoController::getPhotosCountAction',  '_format' => 'json',));
                }
                not_get_photos_count:

                // get_photo
                if (preg_match('#^/photos/(?P<id>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_photo;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_photo')), array (  '_controller' => 'AppBundle\\Controller\\PhotoController::getPhotoAction',  '_format' => 'json',));
                }
                not_get_photo:

                // post_photo
                if (preg_match('#^/photos(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_post_photo;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_photo')), array (  '_controller' => 'AppBundle\\Controller\\PhotoController::postPhotoAction',  '_format' => 'json',));
                }
                not_post_photo:

                // post_photo_upload
                if (0 === strpos($pathinfo, '/photos/uploads') && preg_match('#^/photos/uploads(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_post_photo_upload;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_photo_upload')), array (  '_controller' => 'AppBundle\\Controller\\PhotoController::postPhotoUploadAction',  '_format' => 'json',));
                }
                not_post_photo_upload:

            }

            // put_photo_tags
            if (0 === strpos($pathinfo, '/photo/tags') && preg_match('#^/photo/tags(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'PUT') {
                    $allow[] = 'PUT';
                    goto not_put_photo_tags;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_photo_tags')), array (  '_controller' => 'AppBundle\\Controller\\PhotoController::putPhotoTagsAction',  '_format' => 'json',));
            }
            not_put_photo_tags:

            // delete_photo
            if (0 === strpos($pathinfo, '/photos') && preg_match('#^/photos/(?P<id>[^/\\.]++)(?:\\.(?P<_format>xml|json|html))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'DELETE') {
                    $allow[] = 'DELETE';
                    goto not_delete_photo;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_photo')), array (  '_controller' => 'AppBundle\\Controller\\PhotoController::deletePhotoAction',  '_format' => 'json',));
            }
            not_delete_photo:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
