<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Actucamp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Actucamp controller.
 *
 * @Route("admin/actucamp")
 */
class ActucampController extends Controller
{
    /**
     * Lists all actucamp entities.
     *
     * @Route("/", name="admin_actucamp_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $actucamps = $em->getRepository('AppBundle:Actucamp')->findAll();

        return $this->render('actucamp/index.html.twig', array(
            'actucamps' => $actucamps,
        ));
    }

    /**
     * Creates a new actucamp entity.
     *
     * @Route("/new", name="admin_actucamp_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $actucamp = new Actucamp();
        $form = $this->createForm('AppBundle\Form\ActucampType', $actucamp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($actucamp);
            $em->flush();

            return $this->redirectToRoute('admin_actucamp_show', array('slug' => $actucamp->getSlug()));
        }

        return $this->render('actucamp/new.html.twig', array(
            'actucamp' => $actucamp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a actucamp entity.
     *
     * @Route("/{slug}", name="admin_actucamp_show")
     * @Method("GET")
     */
    public function showAction(Actucamp $actucamp)
    {
        $deleteForm = $this->createDeleteForm($actucamp);

        return $this->render('actucamp/show.html.twig', array(
            'actucamp' => $actucamp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing actucamp entity.
     *
     * @Route("/{slug}/edit", name="admin_actucamp_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Actucamp $actucamp)
    {
        $deleteForm = $this->createDeleteForm($actucamp);
        $editForm = $this->createForm('AppBundle\Form\ActucampType', $actucamp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_actucamp_show', array('slug' => $actucamp->getSlug()));
        }

        return $this->render('actucamp/edit.html.twig', array(
            'actucamp' => $actucamp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a actucamp entity.
     *
     * @Route("/{id}", name="admin_actucamp_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Actucamp $actucamp)
    {
        $form = $this->createDeleteForm($actucamp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($actucamp);
            $em->flush();
        }

        return $this->redirectToRoute('admin_actucamp_index');
    }

    /**
     * Creates a form to delete a actucamp entity.
     *
     * @param Actucamp $actucamp The actucamp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Actucamp $actucamp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_actucamp_delete', array('id' => $actucamp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
