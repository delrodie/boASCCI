<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typactualite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typactualite controller.
 *
 * @Route("admin/typactualite")
 */
class TypactualiteController extends Controller
{
    /**
     * Lists all typactualite entities.
     *
     * @Route("/", name="admin_typactualite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typactualites = $em->getRepository('AppBundle:Typactualite')->findAll();

        return $this->render('typactualite/index.html.twig', array(
            'typactualites' => $typactualites,
        ));
    }

    /**
     * Creates a new typactualite entity.
     *
     * @Route("/new", name="admin_typactualite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typactualite = new Typactualite();
        $form = $this->createForm('AppBundle\Form\TypactualiteType', $typactualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typactualite);
            $em->flush();

            return $this->redirectToRoute('admin_typactualite_index');
        }

        return $this->render('typactualite/new.html.twig', array(
            'typactualite' => $typactualite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typactualite entity.
     *
     * @Route("/{id}", name="admin_typactualite_show")
     * @Method("GET")
     */
    public function showAction(Typactualite $typactualite)
    {
        $deleteForm = $this->createDeleteForm($typactualite);

        return $this->render('typactualite/show.html.twig', array(
            'typactualite' => $typactualite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typactualite entity.
     *
     * @Route("/{slug}/edit", name="admin_typactualite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typactualite $typactualite)
    {
        $deleteForm = $this->createDeleteForm($typactualite);
        $editForm = $this->createForm('AppBundle\Form\TypactualiteType', $typactualite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_typactualite_index');
        }

        return $this->render('typactualite/edit.html.twig', array(
            'typactualite' => $typactualite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typactualite entity.
     *
     * @Route("/{id}", name="admin_typactualite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typactualite $typactualite)
    {
        $form = $this->createDeleteForm($typactualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typactualite);
            $em->flush();
        }

        return $this->redirectToRoute('admin_typactualite_index');
    }

    /**
     * Creates a form to delete a typactualite entity.
     *
     * @param Typactualite $typactualite The typactualite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typactualite $typactualite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_typactualite_delete', array('id' => $typactualite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
