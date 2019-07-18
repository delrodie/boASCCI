<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class DocumentController
 * @Route("/documents-a-telecharger")
 */
class DocumentController extends Controller
{
    /**
     * @Route("/", name="frontend_document_index")
     */
    public function indexAction()
    {
        return $this->render('frontend/document_telecharge.html.twig');
    }
}
