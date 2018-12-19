<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Facebook;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Facebook controller.
 *
 * @Route("admin/facebook")
 * @Security("has_role('ROLE_ADMIN')")
 */
class FacebookController extends Controller
{
    /**
     * Lists all facebook entities.
     *
     * @Route("/", name="admin_facebook_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $facebooks = $em->getRepository('AppBundle:Facebook')->findAll();

        return $this->render('facebook/index.html.twig', array(
            'facebooks' => $facebooks,
        ));
    }

    /**
     * Creates a new facebook entity.
     *
     * @Route("/new", name="admin_facebook_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $facebook = new Facebook();
        $form = $this->createForm('AppBundle\Form\FacebookType', $facebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facebook);
            $em->flush();

            return $this->redirectToRoute('admin_facebook_index');
        }

        return $this->render('facebook/new.html.twig', array(
            'facebook' => $facebook,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a facebook entity.
     *
     * @Route("/{id}", name="admin_facebook_show")
     * @Method("GET")
     */
    public function showAction(Facebook $facebook)
    {
        $deleteForm = $this->createDeleteForm($facebook);

        return $this->render('facebook/show.html.twig', array(
            'facebook' => $facebook,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing facebook entity.
     *
     * @Route("/{id}/edit", name="admin_facebook_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Facebook $facebook)
    {
        $deleteForm = $this->createDeleteForm($facebook);
        $editForm = $this->createForm('AppBundle\Form\FacebookType', $facebook);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_facebook_index');
        }

        return $this->render('facebook/edit.html.twig', array(
            'facebook' => $facebook,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a facebook entity.
     *
     * @Route("/{id}", name="admin_facebook_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Facebook $facebook)
    {
        $form = $this->createDeleteForm($facebook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facebook);
            $em->flush();
        }

        return $this->redirectToRoute('admin_facebook_index');
    }

    /**
     * Creates a form to delete a facebook entity.
     *
     * @param Facebook $facebook The facebook entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Facebook $facebook)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_facebook_delete', array('id' => $facebook->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
