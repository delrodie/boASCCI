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
     * Affichage des produits par categorie
     *
     * @Route("", name="boutique_categorie")
     */
    public function categorieAction(Request $request)
    {
        $categorieSlug = $request->get('categorie'); //dump($categorieSlug);die();
        $em = $this->getDoctrine()->getManager();
        if ($categorieSlug === "0"){
            return $this->redirectToRoute('boutique_index');
        }
        $categorie = $em->getRepository('AppBundle:Categorie')->findOneBy(['slug'=>$categorieSlug]);
        $produits = $em->getRepository('AppBundle:Produit')->findBy(['categorie'=>$categorie->getId(), 'statut'=>1]);
        $categories = $em->getRepository('AppBundle:Categorie')->findBy(['statut'=>1]);
        $brand = $em->getRepository('AppBundle:Brandboutique')->findOneBy(['statut'=>1], ['id'=>'DESC']);

        return $this->render('frontend/boutique_list.html.twig',[
            'produits' => $produits,
            'categories' => $categories,
            'brand' => $brand
        ]);
    }

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
        $brand = $em->getRepository('AppBundle:Brandboutique')->findOneBy(['statut'=>1], ['id'=>'DESC']);

        if (!$produits){ //dump('error500.html');die();
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render('frontend/boutique_list.html.twig',[
            'produits' => $produits,
            'categories' => $categories,
            'brand' => $brand,
        ]);
    }

    /**
     * Affichage du produit
     *
     * @Route("/{categorie}/{slug}", name="boutique_article")
     */
    public function produitAction($categorie, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AppBundle:Produit')->findOneBy(array('slug'=>$slug));
        $similaires = $em->getRepository('AppBundle:Produit')->findSimilaire($categorie, $slug, 4, 0);
        $brand = $em->getRepository('AppBundle:Brandboutique')->findOneBy(['statut'=>1], ['id'=>'DESC']);

        if (!$produit){ //dump('error500.html');die();
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render('frontend/boutique_article.html.twig',[
            'produit' => $produit,
            'similaires' => $similaires,
            'brand' => $brand
        ]);
    }
}
