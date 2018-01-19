<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends Controller
{
    /**
     * @Route("/information", name="fo_information")
     */
    public function informationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $infos = $em->getRepository('AppBundle:Information')->findThreeLastInfos(0,3);
        //dump($infos);die();

        return $this->render('frontend/information.html.twig', [
            'infos' => $infos,
        ]);
		
    }

    /**
     * @Route("/information/{slug}", name="fo_information_breve")
     */
    public function informationBreveAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $info = $em->getRepository('AppBundle:Information')->findInformationBySlug($slug); //dump($info);die();
        $similaires = $em->getRepository('AppBundle:Information')->findThreeLastInfos(0,3); //dump($similaires);die();

        return $this->render('frontend/pageInformation.html.twig',[
            'info' => $info,
            'similaires' => $similaires,
        ]);
    }
}
