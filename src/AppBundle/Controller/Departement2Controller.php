<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Departement2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Departement2 controller.
 *
 * @Route("admin/departement2")
 */
class Departement2Controller extends Controller
{
    /**
     * Lists all departement2 entities.
     *
     * @Route("/", name="admin_departement2_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $departement2s = $em->getRepository('AppBundle:Departement2')->findAll();

        return $this->render('departement2/index.html.twig', array(
            'departement2s' => $departement2s,
        ));
    }

    /**
     * Creates a new departement2 entity.
     *
     * @Route("/new", name="admin_departement2_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $departement2 = new Departement2();
        $form = $this->createForm('AppBundle\Form\Departement2Type', $departement2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($departement2);
            $em->flush();

            return $this->redirectToRoute('admin_departement2_show', array('slug' => $departement2->getSlug()));
        }

        return $this->render('departement2/new.html.twig', array(
            'departement2' => $departement2,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a departement2 entity.
     *
     * @Route("/{slug}", name="admin_departement2_show")
     * @Method("GET")
     */
    public function showAction(Departement2 $departement2)
    {
        $deleteForm = $this->createDeleteForm($departement2);

        return $this->render('departement2/show.html.twig', array(
            'departement2' => $departement2,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing departement2 entity.
     *
     * @Route("/{slug}/edit", name="admin_departement2_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Departement2 $departement2)
    {
        $deleteForm = $this->createDeleteForm($departement2);
        $editForm = $this->createForm('AppBundle\Form\Departement2Type', $departement2);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_departement2_show', array('slug' => $departement2->getSlug()));
        }

        return $this->render('departement2/edit.html.twig', array(
            'departement2' => $departement2,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a departement2 entity.
     *
     * @Route("/{id}", name="admin_departement2_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Departement2 $departement2)
    {
        $form = $this->createDeleteForm($departement2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($departement2);
            $em->flush();
        }

        return $this->redirectToRoute('admin_departement2_index');
    }

    /**
     * Creates a form to delete a departement2 entity.
     *
     * @param Departement2 $departement2 The departement2 entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Departement2 $departement2)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_departement2_delete', array('id' => $departement2->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
