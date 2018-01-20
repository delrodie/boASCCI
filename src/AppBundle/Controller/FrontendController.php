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

    /**
     * @Route("/partenaires", name="fo_partenaires")
     */
    public function listePartenairesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $partenaires = $em->getRepository('AppBundle:Partenaire')->findBy(array('statut' => 1)); //dump($partenaires);//die();

        return $this->render('frontend/partenaire.html.twig',[
            'partenaires'   => $partenaires
        ]);
    }

    /**
     * @Route("/actualite-nationale/{slug}", name="fo_nationale")
     */
    public function nationaleAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getmanager();

        $nationale = $em->getRepository('AppBundle:Actualite')->findOneBy(array('slug' => $slug)); //dump($nationale);die();
        $similaires = $em->getRepository('AppBundle:Actualite')->findThreeLastActualite($slug, 0, 2); //dump($nationale);die();

        return $this->render('frontend/pageNationale.html.twig',[
            'nationale' => $nationale,
            'similaires' => $similaires,
        ]);
    }

    /**
     * @Route("/actualite-regionale/{slug}", name="fo_regionale")
     */
    public function regionaleAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getmanager();

        $regionale = $em->getRepository('AppBundle:Regionale')->findOneBy(array('slug' => $slug)); //dump($nationale);die();
        $similaires = $em->getRepository('AppBundle:Regionale')->findThreeLastRegionale($slug, 0, 2); //dump($nationale);die();

        return $this->render('frontend/pageRegionale.html.twig',[
            'regionale' => $regionale,
            'similaires' => $similaires,
        ]);
    }

    /**
     * @Route("/actualite-internationale/{slug}", name="fo_internationale")
     */
    public function internationaleAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getmanager();

        $internationale = $em->getRepository('AppBundle:Internationale')->findOneBy(array('slug' => $slug)); //dump($nationale);die();
        $similaires = $em->getRepository('AppBundle:Internationale')->findThreeLastInternationale($slug, 0, 2); //dump($nationale);die();

        return $this->render('frontend/pageInternationale.html.twig',[
            'internationale' => $internationale,
            'similaires' => $similaires,
        ]);
    }
}
