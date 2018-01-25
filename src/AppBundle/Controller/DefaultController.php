<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository('AppBundle:Slider')->findSlideStandard(0, 4); //dump($sliders);die();
        $slideUniques = $em->getRepository('AppBundle:Slider')->findOneSlide(5, 1); //dump($slideUnique);die();
        $envolIntros = $em->getRepository('AppBundle:Envol')->findOneEnvol(0, 1); //dump($envolIntro);die();
        $envols = $em->getRepository('AppBundle:Envol')->findEnvol(); //dump($envols);die();
        $nationales = $em->getRepository('AppBundle:Actualite')->findLastActualite(0, 3);
        $regionales = $em->getRepository('AppBundle:Regionale')->findLastRegionale(0, 4);
        $internationales = $em->getRepository('AppBundle:Internationale')->findLastInternationale(0, 3);

        return $this->render('default/index.html.twig', [
            'sliders'   => $sliders,
            'slideUniques'   => $slideUniques,
            'envolIntros'    => $envolIntros,
            'envols' => $envols,
            'nationales' => $nationales,
            'regionales' => $regionales,
            'internationales' => $internationales,
        ]);
		
    }

    /**
     * @Route("/chef", name="menu_chef")
     */
    public function menuChefAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $menus = $em->getRepository('AppBundle:Chef')->findBy(array('statut' => 1));

        return $this->render('default/menu.html.twig',[
            'menus' => $menus,
        ]);
    }

    /**
     * @Route("/presentation", name="menu_presentation")
     */
    public function menuPresentationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $menus = $em->getRepository('AppBundle:Typresentation')->findBy(array('statut' => 1));

        return $this->render('default/menu.html.twig',[
            'menus' => $menus,
        ]);
    }

    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('default/dashboard.html.twig');
    }
}
