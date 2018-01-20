<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Information;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Information controller.
 *
 * @Route("admin/information")
 */
class InformationController extends Controller
{
    /**
     * Lists all information entities.
     *
     * @Route("/", name="admin_information_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $information = $em->getRepository('AppBundle:Information')->findAll();

        return $this->render('information/index.html.twig', array(
            'information' => $information,
        ));
    }

    /**
     * Creates a new information entity.
     *
     * @Route("/new", name="admin_information_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $information = new Information();
        $form = $this->createForm('AppBundle\Form\InformationType', $information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($information);
            $em->flush();

            return $this->redirectToRoute('admin_information_show', array('slug' => $information->getSlug()));
        }

        return $this->render('information/new.html.twig', array(
            'information' => $information,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a information entity.
     *
     * @Route("/{slug}", name="admin_information_show")
     * @Method("GET")
     */
    public function showAction(Information $information)
    {
        $deleteForm = $this->createDeleteForm($information);

        return $this->render('information/show.html.twig', array(
            'information' => $information,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing information entity.
     *
     * @Route("/{slug}/edit", name="admin_information_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Information $information)
    {
        $deleteForm = $this->createDeleteForm($information);
        $editForm = $this->createForm('AppBundle\Form\InformationType', $information);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_information_show', array('slug' => $information->getSlug()));
        }

        return $this->render('information/edit.html.twig', array(
            'information' => $information,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a information entity.
     *
     * @Route("/{id}", name="admin_information_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Information $information)
    {
        $form = $this->createDeleteForm($information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($information);
            $em->flush();
        }

        return $this->redirectToRoute('admin_information_index');
    }

    /**
     * Creates a form to delete a information entity.
     *
     * @param Information $information The information entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Information $information)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_information_delete', array('id' => $information->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
