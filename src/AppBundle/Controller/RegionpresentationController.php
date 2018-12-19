<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Regionpresentation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Regionpresentation controller.
 *
 * @Route("admin/regionpresentation")
 * @Security("has_role('ROLE_ADMIN')")
 */
class RegionpresentationController extends Controller
{
    /**
     * Lists all regionpresentation entities.
     *
     * @Route("/", name="admin_regionpresentation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $regionpresentations = $em->getRepository('AppBundle:Regionpresentation')->findAll();

        return $this->render('regionpresentation/index.html.twig', array(
            'regionpresentations' => $regionpresentations,
        ));
    }

    /**
     * Creates a new regionpresentation entity.
     *
     * @Route("/new", name="admin_regionpresentation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $regionpresentation = new Regionpresentation();
        $form = $this->createForm('AppBundle\Form\RegionpresentationType', $regionpresentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($regionpresentation);
            $em->flush();

            return $this->redirectToRoute('admin_regionpresentation_show', array('slug' => $regionpresentation->getSlug()));
        }

        return $this->render('regionpresentation/new.html.twig', array(
            'regionpresentation' => $regionpresentation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a regionpresentation entity.
     *
     * @Route("/{slug}", name="admin_regionpresentation_show")
     * @Method("GET")
     */
    public function showAction(Regionpresentation $regionpresentation)
    {
        $deleteForm = $this->createDeleteForm($regionpresentation);

        return $this->render('regionpresentation/show.html.twig', array(
            'regionpresentation' => $regionpresentation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing regionpresentation entity.
     *
     * @Route("/{slug}/edit", name="admin_regionpresentation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Regionpresentation $regionpresentation)
    {
        $deleteForm = $this->createDeleteForm($regionpresentation);
        $editForm = $this->createForm('AppBundle\Form\RegionpresentationType', $regionpresentation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_regionpresentation_show', array('slug' => $regionpresentation->getSlug()));
        }

        return $this->render('regionpresentation/edit.html.twig', array(
            'regionpresentation' => $regionpresentation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a regionpresentation entity.
     *
     * @Route("/{id}", name="admin_regionpresentation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Regionpresentation $regionpresentation)
    {
        $form = $this->createDeleteForm($regionpresentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($regionpresentation);
            $em->flush();
        }

        return $this->redirectToRoute('admin_regionpresentation_index');
    }

    /**
     * Creates a form to delete a regionpresentation entity.
     *
     * @param Regionpresentation $regionpresentation The regionpresentation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Regionpresentation $regionpresentation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_regionpresentation_delete', array('id' => $regionpresentation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
