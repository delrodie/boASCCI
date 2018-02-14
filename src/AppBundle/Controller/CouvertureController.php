<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Couverture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Couverture controller.
 *
 * @Route("admin/couverture")
 */
class CouvertureController extends Controller
{
    /**
     * Lists all couverture entities.
     *
     * @Route("/", name="admin_couverture_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $couvertures = $em->getRepository('AppBundle:Couverture')->findAll();

        return $this->render('couverture/index.html.twig', array(
            'couvertures' => $couvertures,
        ));
    }

    /**
     * Creates a new couverture entity.
     *
     * @Route("/new", name="admin_couverture_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $couverture = new Couverture();
        $form = $this->createForm('AppBundle\Form\CouvertureType', $couverture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($couverture);
            $em->flush();

            return $this->redirectToRoute('admin_couverture_show', array('id' => $couverture->getId()));
        }

        return $this->render('couverture/new.html.twig', array(
            'couverture' => $couverture,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a couverture entity.
     *
     * @Route("/{id}", name="admin_couverture_show")
     * @Method("GET")
     */
    public function showAction(Couverture $couverture)
    {
        $deleteForm = $this->createDeleteForm($couverture);

        return $this->render('couverture/show.html.twig', array(
            'couverture' => $couverture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing couverture entity.
     *
     * @Route("/{id}/edit", name="admin_couverture_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Couverture $couverture)
    {
        $deleteForm = $this->createDeleteForm($couverture);
        $editForm = $this->createForm('AppBundle\Form\CouvertureType', $couverture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_couverture_show', array('id' => $couverture->getId()));
        }

        return $this->render('couverture/edit.html.twig', array(
            'couverture' => $couverture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a couverture entity.
     *
     * @Route("/{id}", name="admin_couverture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Couverture $couverture)
    {
        $form = $this->createDeleteForm($couverture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($couverture);
            $em->flush();
        }

        return $this->redirectToRoute('admin_couverture_index');
    }

    /**
     * Creates a form to delete a couverture entity.
     *
     * @param Couverture $couverture The couverture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Couverture $couverture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_couverture_delete', array('id' => $couverture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
