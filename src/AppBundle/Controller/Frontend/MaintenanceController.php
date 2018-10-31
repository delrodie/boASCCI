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
        die('ici');
    }
}