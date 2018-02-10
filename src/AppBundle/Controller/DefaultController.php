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


        $sliders = $em->getRepository('AppBundle:Slider')->findSlideStandard(0, 5); //dump($sliders);die();
        $slideUniques = $em->getRepository('AppBundle:Slider')->findOneSlide(5, 1); //dump($slideUniques);die();
        $envolIntros = $em->getRepository('AppBundle:Envol')->findOneEnvol(0, 1); //dump($envolIntro);die();
        $envols = $em->getRepository('AppBundle:Envol')->findEnvol(); //dump($envols);die();
        $nationales = $em->getRepository('AppBundle:Actualite')->findLastActualite(0, 3);
        $regionales = $em->getRepository('AppBundle:Regionale')->findLastRegionale(0, 4);
        $internationales = $em->getRepository('AppBundle:Internationale')->findLastInternationale(0, 3);
        $messages = $em->getRepository('AppBundle:Message')
                        ->findBy(
                            array('statut' => 1),
                            array('id' => 'DESC'),
                            $limit = 1,
                            $offset = 0
                        );

        return $this->render('default/index.html.twig', [
            'sliders'   => $sliders,
            'slideUniques'   => $slideUniques,
            'envolIntros'    => $envolIntros,
            'envols' => $envols,
            'nationales' => $nationales,
            'regionales' => $regionales,
            'internationales' => $internationales,
            'messages'  => $messages,
        ]);
		
    }

    /**
     * @Route("/chef", name="menu_chef")
     */
    public function menuChefAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $menus = $em->getRepository('AppBundle:Chef')->findBy(array('statut' => 1));

        return $this->render('default/menuChef.html.twig',[
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

    /**
     * @Route("/publicite", name="menu_publicite")
     */
    public function publiciteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $publicites = $em->getRepository('AppBundle:Publicite')->findPublicite(0,1);

        if (!$publicites){
            return $this->render('frontend/noPublicite.html.twig');
        }

        return $this->render('frontend/publicite.html.twig',[
            'publicites' => $publicites,
        ]);
    }
}
