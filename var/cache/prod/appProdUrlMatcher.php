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

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
