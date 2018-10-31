<?php

namespace AppBundle\Controller\Frontend;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class MaintenanceController
 * @Route("maintenances")
 */
class MaintenanceController extends Controller
{
    /**
     * @Route("/", name="maintenance_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$maintenances = $em->getRepository('AppBundle:Maintenance')->findBy(array('statut'=>1), array('id'=>'DESC'),1,0);

        $sliders = $em->getRepository('AppBundle:Slider')->findSlideStandard(0, 6); //dump($sliders);die();
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
        $facebooks = $em->getRepository('AppBundle:Facebook')->findLastFacebook();//dump($facebooks);die();

        if ($bloc) {

            $actucamps = $em->getRepository('AppBundle:Actucamp')->findBy(array('statut'=>1), array('id'=>'DESC'), 4, 0);

            return $this->render('default/index_campbranche.html.twig', [
                'sliders'   => $sliders,
                'nationales' => $nationales,
                'actucamps' => $actucamps,
                'internationales' => $internationales,
                'messages'  => $messages,
                'publicites' => $publicites,
                'facebooks' => $facebooks,
            ]);

        } else {
            $regionales = $em->getRepository('AppBundle:Regionale')->findLastRegionale(0, 4);

            return $this->render('default/index_orange1.html.twig', [
                'sliders'   => $sliders,
                'nationales' => $nationales,
                'regionales' => $regionales,
                'internationales' => $internationales,
                'messages'  => $messages,
                'publicites' => $publicites,
                'facebooks' => $facebooks,
            ]);
        }
    }

    /**
     * @Route("/vert", name="maintenance_index")
     */
    public function vertAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$maintenances = $em->getRepository('AppBundle:Maintenance')->findBy(array('statut'=>1), array('id'=>'DESC'),1,0);

        $sliders = $em->getRepository('AppBundle:Slider')->findSlideStandard(0, 6); //dump($sliders);die();
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
        $facebooks = $em->getRepository('AppBundle:Facebook')->findLastFacebook();//dump($facebooks);die();

        if ($bloc) {

            $actucamps = $em->getRepository('AppBundle:Actucamp')->findBy(array('statut'=>1), array('id'=>'DESC'), 4, 0);

            return $this->render('default/index_campbranche.html.twig', [
                'sliders'   => $sliders,
                'nationales' => $nationales,
                'actucamps' => $actucamps,
                'internationales' => $internationales,
                'messages'  => $messages,
                'publicites' => $publicites,
                'facebooks' => $facebooks,
            ]);

        } else {
            $regionales = $em->getRepository('AppBundle:Regionale')->findLastRegionale(0, 4);

            return $this->render('default/index_vert.html.twig', [
                'sliders'   => $sliders,
                'nationales' => $nationales,
                'regionales' => $regionales,
                'internationales' => $internationales,
                'messages'  => $messages,
                'publicites' => $publicites,
                'facebooks' => $facebooks,
            ]);
        }
    }
}