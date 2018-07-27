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

        $sliders = $em->getRepository('AppBundle:Slider')->findSlideStandard(0, 6);
        $nationales = $em->getRepository('AppBundle:Actualite')->findLastActualite(0, 3);
        
        $internationales = $em->getRepository('AppBundle:Internationale')->findLastInternationale(0, 3);
        $publicites = $em->getRepository('AppBundle:Publicite')->findPublicite(0,1);//dump($publicites);die();
        //$publicites = $em->getRepository('AppBundle:Publicite')->findPublicite(0,1);dump($publicites);die();
        $messages = $em->getRepository('AppBundle:Message')
                        ->findBy(
                            array('statut' => 1),
                            array('id' => 'DESC'),
                            $limit = 1,
                            $offset = 0
                        );


        //return $this->render('default/maintenance.html.twig');

        $bloc = $em->getRepository('AppBundle:BlockCamp')->findBy(array('enabled'=>1), array('id'=>'DESC'), 1, 0);

        if ($bloc) {

            $actucamps = $em->getRepository('AppBundle:Actucamp')->findBy(array('statut'=>1), array('id'=>'DESC'), 4, 0);

            return $this->render('default/index_campbranche.html.twig', [
                'sliders'   => $sliders,
                'nationales' => $nationales,
                'actucamps' => $actucamps,
                'internationales' => $internationales,
                'messages'  => $messages,
                'publicites' => $publicites,
            ]);

        } else {
            $regionales = $em->getRepository('AppBundle:Regionale')->findLastRegionale(0, 4);

            return $this->render('default/index.html.twig', [
                'sliders'   => $sliders,
                'nationales' => $nationales,
                'regionales' => $regionales,
                'internationales' => $internationales,
                'messages'  => $messages,
                'publicites' => $publicites,
            ]);
        }
        
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
     * @Route("/video", name="menu_video")
     */
    public function publiciteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('AppBundle:Video')->findVideo(0,1);

        if (!$videos){
            return $this->render('frontend/noPublicite.html.twig');
        }

        return $this->render('frontend/publicite.html.twig',[
            'videos' => $videos,
        ]);
    }
}
