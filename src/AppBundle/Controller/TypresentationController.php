<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typresentation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typresentation controller.
 *
 * @Route("admin/typresentation")
 * @Security("has_role('ROLE_ADMIN')")
 */
class TypresentationController extends Controller
{
    /**
     * Lists all typresentation entities.
     *
     * @Route("/", name="admin_typresentation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typresentations = $em->getRepository('AppBundle:Typresentation')->findAll();

        return $this->render('typresentation/index.html.twig', array(
            'typresentations' => $typresentations,
        ));
    }

    /**
     * Creates a new typresentation entity.
     *
     * @Route("/new", name="admin_typresentation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typresentation = new Typresentation();
        $form = $this->createForm('AppBundle\Form\TypresentationType', $typresentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typresentation);
            $em->flush();

            return $this->redirectToRoute('admin_typresentation_index');
        }

        return $this->render('typresentation/new.html.twig', array(
            'typresentation' => $typresentation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typresentation entity.
     *
     * @Route("/{id}", name="admin_typresentation_show")
     * @Method("GET")
     */
    public function showAction(Typresentation $typresentation)
    {
        $deleteForm = $this->createDeleteForm($typresentation);

        return $this->render('typresentation/show.html.twig', array(
            'typresentation' => $typresentation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typresentation entity.
     *
     * @Route("/{slug}/edit", name="admin_typresentation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typresentation $typresentation)
    {
        $deleteForm = $this->createDeleteForm($typresentation);
        $editForm = $this->createForm('AppBundle\Form\TypresentationType', $typresentation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_typresentation_index');
        }

        return $this->render('typresentation/edit.html.twig', array(
            'typresentation' => $typresentation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typresentation entity.
     *
     * @Route("/{id}", name="admin_typresentation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typresentation $typresentation)
    {
        $form = $this->createDeleteForm($typresentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typresentation);
            $em->flush();
        }

        return $this->redirectToRoute('admin_typresentation_index');
    }

    /**
     * Creates a form to delete a typresentation entity.
     *
     * @param Typresentation $typresentation The typresentation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typresentation $typresentation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_typresentation_delete', array('id' => $typresentation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
