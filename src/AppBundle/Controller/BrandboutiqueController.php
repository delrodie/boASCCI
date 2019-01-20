<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Brandboutique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Brandboutique controller.
 *
 * @Route("admin/brandboutique")
 */
class BrandboutiqueController extends Controller
{
    /**
     * Lists all brandboutique entities.
     *
     * @Route("/", name="admin_brandboutique_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $brandboutique = new Brandboutique();
        $form = $this->createForm('AppBundle\Form\BrandboutiqueType', $brandboutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brandboutique);
            $em->flush();

            return $this->redirectToRoute('admin_brandboutique_index');
        }

        $brandboutiques = $em->getRepository('AppBundle:Brandboutique')->findAll();

        return $this->render('brandboutique/index.html.twig', array(
            'brandboutiques' => $brandboutiques,
            'brandboutique' => $brandboutique,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new brandboutique entity.
     *
     * @Route("/new", name="admin_brandboutique_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $brandboutique = new Brandboutique();
        $form = $this->createForm('AppBundle\Form\BrandboutiqueType', $brandboutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($brandboutique);
            $em->flush();

            return $this->redirectToRoute('admin_brandboutique_show', array('id' => $brandboutique->getId()));
        }

        return $this->render('brandboutique/new.html.twig', array(
            'brandboutique' => $brandboutique,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a brandboutique entity.
     *
     * @Route("/{id}", name="admin_brandboutique_show")
     * @Method("GET")
     */
    public function showAction(Brandboutique $brandboutique)
    {
        $deleteForm = $this->createDeleteForm($brandboutique);

        return $this->render('brandboutique/show.html.twig', array(
            'brandboutique' => $brandboutique,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing brandboutique entity.
     *
     * @Route("/{id}/edit", name="admin_brandboutique_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Brandboutique $brandboutique)
    {
        $deleteForm = $this->createDeleteForm($brandboutique);
        $editForm = $this->createForm('AppBundle\Form\BrandboutiqueType', $brandboutique);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_brandboutique_index');
        }
        $em = $this->getDoctrine()->getManager();

        $brandboutiques = $em->getRepository('AppBundle:Brandboutique')->findAll();

        return $this->render('brandboutique/edit.html.twig', array(
            'brandboutique' => $brandboutique,
            'brandboutiques' => $brandboutiques,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a brandboutique entity.
     *
     * @Route("/{id}", name="admin_brandboutique_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Brandboutique $brandboutique)
    {
        $form = $this->createDeleteForm($brandboutique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($brandboutique);
            $em->flush();
        }

        return $this->redirectToRoute('admin_brandboutique_index');
    }

    /**
     * Creates a form to delete a brandboutique entity.
     *
     * @param Brandboutique $brandboutique The brandboutique entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Brandboutique $brandboutique)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_brandboutique_delete', array('id' => $brandboutique->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
