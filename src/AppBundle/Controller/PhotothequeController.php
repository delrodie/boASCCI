<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Galerie controller.
 *
 * @Route("phototheque")
 */
class PhotothequeController extends Controller
{
    /**
     * Liste des galeries.
     *
     * @Route("/", name="phototheque_galerie")
     * @Method("GET")
     */
    public function galerieAction()
    {
        $em = $this->getDoctrine()->getManager();

        $galeries = $em->getRepository('AppBundle:Galerie')->findBy(array('statut'=>1), array('id'=>'DESC'));

        return $this->render('frontend/galerie.html.twig', array(
            'galeries' => $galeries,
        ));
    }

    /**
     * Liste des photos correspondantes à la galerie
     *
     * @Route("/{galerie}", name="phototheque_photo")
     * @Method("GET")
     */
    public function photoAction($galerie)
    {
        $em = $this->getDoctrine()->getManager();

        $galery = $em->getRepository('AppBundle:Galerie')->findOneBy(array('slug'=>$galerie));
        $photos = $em->getRepository('AppBundle:Photo')->findBy(array('galerie'=>$galery->getId()));

        return $this->render('frontend/phototheque.html.twig', [
            'galerie' => $galery,
            'photos'  => $photos,
        ]);
    }

}
