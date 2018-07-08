<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        //$info = $em->getRepository('AppBundle:Information')->findInformationBySlug($slug); //dump($info);die();
        $info = $em->getRepository('AppBundle:Information')->findOneBy(array('slug' => $slug, 'statut' => 1)); //dump($info);die();
        $similaires = $em->getRepository('AppBundle:Information')->findThreeLastInfos(0,3); //dump($similaires);die();

        // Si le message n'exite pas alors renvoie à la page de maintenance
        if(!$info){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

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

        $nationale = $em->getRepository('AppBundle:Actualite')->findOneBy(array('slug' => $slug, 'statut' => 1)); //dump($nationale);die();
        $similaires = $em->getRepository('AppBundle:Actualite')->findThreeLastActualite($slug, 0, 3); //dump($nationale);die();

        // Si le message n'exite pas alors renvoie à la page de maintenance
        if(!$nationale){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

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

        $regionale = $em->getRepository('AppBundle:Regionale')->findOneBy(array('slug' => $slug, 'statut' => 1)); //dump($nationale);die();
        $similaires = $em->getRepository('AppBundle:Regionale')->findThreeLastRegionale($slug, 0, 3); //dump($nationale);die();

        // Si le message n'exite pas alors renvoie à la page de maintenance
        if(!$regionale){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

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
        $em = $this->getDoctrine()->getManager();

        $internationale = $em->getRepository('AppBundle:Internationale')->findOneBy(array('slug' => $slug, 'statut' => 1)); //dump($nationale);die();
        $similaires = $em->getRepository('AppBundle:Internationale')->findThreeLastInternationale($slug, 0, 3); //dump($nationale);die();

        // Si le message n'exite pas alors renvoie à la page de maintenance
        if(!$internationale){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render('frontend/pageInternationale.html.twig',[
            'internationale' => $internationale,
            'similaires' => $similaires,
        ]);
    }

    /**
     * @Route("/pedagogie/{slug}", name="fo_pedagogie")
     */
    public function pedagogieAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $pedagogies = $em->getRepository('AppBundle:Pedagogie')->findPedagogie($slug); //dump($pedagogie);die();

        if (!$pedagogies){ //dump('error500.html');die();
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render('frontend/pagePedagogie.html.twig',[
            'pedagogies' => $pedagogies,
        ]);
    }

    /**
     * @Route("/qui-sommes-nous/{slug}", name="fo_presentation")
     */
    public function presentationAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $presentations = $em->getRepository('AppBundle:Presentation')->findPresentation($slug);

        // Si aucun élément alors renvoyer à la page de maintenance
        if (!$presentations) {
            return $this->render('frontend/pageMaintenance.html.twig');
        }//dump($presentations);die();

        foreach ($presentations as $index => $presentation) {
            $slugCherche = $em->getRepository('AppBundle:Presentation')->verifSlug($presentation->getTypresentation()->getSlug());
            $verif = $em->getRepository('AppBundle:Presentation')->verifSlug($slug = 'equipe');

            if ($verif){
                if ($verif->getSlug() == $slugCherche->getSlug()){
                    $national = $em->getRepository('AppBundle:Equipe')->findMembre($slug = 'national');
                    //$adjoints = $em->getRepository('AppBundle:Equipe')->findMembreByTypefonction($slug="adjoint");
                    //$assistants = $em->getRepository('AppBundle:Equipe')->findMembreByTypefonction($slug="assistant");
                    //$internationaux = $em->getRepository('AppBundle:Equipe')->findMembreByDepartement($slug="internationa");
                    //$secretariat = $em->getRepository('AppBundle:Equipe')->findMembre($slug="secreta");
		    $secretariat = $em->getRepository('AppBundle:Equipe')->findMembreByTypefonction($slug="secretaire-du-c-n");
                    $aumonier = $em->getRepository('AppBundle:Equipe')->findMembre($slug="aumon");
                    $adjoints = $em->getRepository('AppBundle:Equipe')->findBy(array('statut'=> 1, 'cna'=>1));
                    $assistants = $em->getRepository('AppBundle:Equipe')->findBy(array('statut'=>1, 'acn'=>1));
                    $internationaux = $em->getRepository('AppBundle:Equipe')->findBy(array('statut'=>1, 'si'=>1));
                    $cabinets = $em->getRepository('AppBundle:Equipe')->findBy(array('statut'=>1, 'cc'=>1));
                    $bureaux = $em->getRepository('AppBundle:Equipe')->findBy(array('statut'=>1, 'bn'=>1));

                    return $this->render("frontend/pageEquipe.html.twig",[
                        'presentations' => $presentations,
                        'national'  => $national,
                        'adjoints'  => $adjoints,
                        'assistants'    => $assistants,
                        'internationaux'    => $internationaux,
                        'secretariat'    => $secretariat,
                        'cabinets'  => $cabinets,
                        'bureaux'   => $bureaux,
                        'aumonier'   => $aumonier,
                    ]);
                }
            }
        }

        return $this->render("frontend/pagePresentation.html.twig", [
            'presentations' => $presentations,
        ]);
    }

    /**
     * @Route("/ressources-adultes/{slug}", name="fo_chef")
     */
    public function chefAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $adultes = $em->getRepository('AppBundle:Adulte')->findAdulte($slug);

        // Si aucun éléments alors renvoyer à la page de maintenance
        if (!$adultes){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render("frontend/pageAdulte.html.twig", [
            'adultes' => $adultes,
        ]);
    }

    /**
     * @Route("/message-du-national/{slug}", name="fo_messageNational")
     */
    public function messageAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('AppBundle:Message')->findOneBy(array('slug' => $slug, 'statut' => 1));

        // Si le message n'exite pas alors renvoie à la page de maintenance
        if(!$message){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render("frontend/pageMessage.html.twig", [
            'message'   => $message,
        ]);
    }

    /**
     * @Route("/envol/{slug}", name="fo_envolASCCI")
     */
    public function envolAscciAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $envol = $em->getRepository('AppBundle:Envol')->findOneBy(array('slug' => $slug, 'statut' => 1));

        // Si la rubrique n'existe pas alors renvoie à la page de maintenance
        if(!$envol){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render("frontend/pageEnvol.html.twig",[
            'envol' => $envol,
        ]);
    }

    /**
     * @Route("/presentation/nos-departements", name="fo_presentation_departement")
     */
    public function departementAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $departements = $em->getRepository('AppBundle:Departement2')->findBy(array('statut' => 1));
        //$presentations = $em->getRepository('AppBundle:Presentation')->findBy(array('slug' => 'notre-equipe-dirigeante'));
        $presentations = $em->getRepository('AppBundle:Presentation')->findPresentation($slug = 'notre-equipe-dirigeante');

        //dump($presentations);die();
        // S'il n'y a aucun contenu alors renvoie à la page de maintenance
        if(!$departements){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render('frontend/pageDepartement.html.twig',[
            'departements'  => $departements,
            'presentations' => $presentations,
        ]);
    }

    /**
     * @Route("/qui-sommes-nous/departement/{slug}", name="fo_departement")
     */
    public function departementdetailsAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $departement = $em->getRepository('AppBundle:Departement2')->findOneBy(array('slug' => $slug, 'statut' => 1));

        // S'il n'y a aucun article alors renvoie à la page de maintenance
        if(!$departement){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render('frontend/pageDepartement_detail.html.twig',[
            'departement'  => $departement,
        ]);
    }

    /**
     * @Route("/grands-rassemblements/{slug}", name="fo_rassemblement")
     */
    public function rassemblementAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $rassemblement = $em->getRepository('AppBundle:Rassemblement')->findRassemblement($slug);

        if (!$rassemblement){
            return $this->render('frontend/pageMaintenance.html.twig');
        }
        $similaires = $em->getRepository('AppBundle:Rassemblement')->findSimilaire($rassemblement->getSlug(),0, 4);
        
        return $this->render("frontend/pageRassemblement.html.twig",[
            'rassemblement' => $rassemblement,
            'similaires'    => $similaires,
        ]);
    }

    /**
     * @Route("/couverture-nationale", name="fo_couverture_nationale")
     */
    public function couvertureAction()
    {
        $em = $this->getDoctrine()->getManager();
        $regions = $em->getRepository('AppBundle:Region')->findBy(array('statut' => 1));
        $couverture = $em->getRepository('AppBundle:Couverture')->findOneBy(array('statut' => 1), array('id' => 'DESC'), 1, 0); //dump($couverture);die();
        return $this->render("frontend/couvertureNationale.html.twig",[
            'regions'   => $regions,
            'couverture'    => $couverture,
        ]);
    }

    /**
     * @Route("/couverture-nationale/{slug}", name="fo_region_presentation")
     */
    public function regionAction(Request $request, $slug)
    {
        $em =$this->getDoctrine()->getManager();
        $regionpresentation = $em->getRepository('AppBundle:Regionpresentation')->findPresentationBy($slug);

        if (!$regionpresentation){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render("frontend/pageRegion.html.twig",[
            'regionpresentation'    => $regionpresentation,
        ]);
    }

    /**
     * @Route("/biographie/{slug}", name="fo_biographie")
     */
    public function biographieAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $biographie = $em->getRepository('AppBundle:Equipe')->findOneBy(array('slug' => $slug));

        if (!$biographie){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        return $this->render("frontend/pageBiographie.html.twig",[
            'biographie'    => $biographie,
        ]);
    }

    /**
     * @Route("/nous-contacter/", name="fo_nous_contacter")
     */
    public function contactAction()
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('AppBundle:Contact')->findOneBy(array('statut' => 1), array('id' => 'DESC'),1,0);

        return $this->render('frontend/pageContact.html.twig',[
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/archives/actualites-{slug}", name="fo_archives_actualites")
     */
    public function archivesAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        if ($slug === "nationales"){
            $actualites = $em->getRepository('AppBundle:Actualite')->findLastActualite(3, 15);

            return $this->render('frontend/archive_nationale.html.twig',[
                'actualites' => $actualites,
            ]);

        }elseif ($slug === "regionales"){
            $actualites = $em->getRepository('AppBundle:Regionale')->findLastRegionale(4, 15);
            return $this->render('frontend/archives.html.twig',[
                'actualites' => $actualites,
            ]);

        }elseif ($slug === "internationales"){
            $actualites = $em->getRepository('AppBundle:Internationale')->findLastInternationale(3, 15);

            return $this->render('frontend/archive_internationale.html.twig',[
                'actualites' => $actualites,
            ]);
        }else{
            return $this->render('frontend/pageMaintenance.html.twig');
        }

        // Si l'actualité n'exite pas alors renvoie à la page de maintenance
        if(!$actualites){
            return $this->render('frontend/pageMaintenance.html.twig');
        }

    }
}
