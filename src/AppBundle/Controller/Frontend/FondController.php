<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FondController
 * @Route("fonds")
 */
class FondController extends Controller
{

    /**
     * @Route("/", name="fonds_national")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $fonds = $em->getRepository("AppBundle:Fonds")->findOneBy(['statut'=>1], ['id'=>'DESC']);
        return $this->render('frontend/fonds.html.twig', [
            'fonds' => $fonds,
        ]);
    }
}
