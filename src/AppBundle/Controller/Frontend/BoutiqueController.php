<?php

namespace AppBundle\Controller\Frontend;


use AppBundle\Entity\Produit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("boutique")
 */
class BoutiqueController extends Controller
{
    /**
     * Liste des articles
     *
     * @Route("/", name="boutique_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager() ;
        $produits = $em->getRepository('AppBundle:Produit')->findBy(array('statut'=>1));
        $categories = $em->getRepository('AppBundle:Categorie')->findBy(array('statut'=>1));

        return $this->render('frontend/boutique_list.html.twig',[
            'produits' => $produits,
            'categories' => $categories
        ]);
    }

    /**
     * Affichage du produit
     *
     * @Route("/{categorie}/{slug}", name="boutique_article")
     */
    public function produitAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AppBundle:Produit')->findOneBy(array('slug'=>$slug));
        $similaires = $em->getRepository('AppBundle:Produit')->findAll();

        return $this->render('frontend/boutique_article.html.twig',[
            'produit' => $produit,
            'similaires' => $similaires
        ]);
    }
}