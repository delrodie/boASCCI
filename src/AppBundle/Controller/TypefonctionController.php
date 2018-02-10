<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typefonction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typefonction controller.
 *
 * @Route("admin/typefonction")
 */
class TypefonctionController extends Controller
{
    /**
     * Lists all typefonction entities.
     *
     * @Route("/", name="admin_typefonction_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typefonctions = $em->getRepository('AppBundle:Typefonction')->findAll();

        return $this->render('typefonction/index.html.twig', array(
            'typefonctions' => $typefonctions,
        ));
    }

    /**
     * Creates a new typefonction entity.
     *
     * @Route("/new", name="admin_typefonction_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typefonction = new Typefonction();
        $form = $this->createForm('AppBundle\Form\TypefonctionType', $typefonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typefonction);
            $em->flush();

            return $this->redirectToRoute('admin_typefonction_index');
        }

        return $this->render('typefonction/new.html.twig', array(
            'typefonction' => $typefonction,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typefonction entity.
     *
     * @Route("/{id}", name="admin_typefonction_show")
     * @Method("GET")
     */
    public function showAction(Typefonction $typefonction)
    {
        $deleteForm = $this->createDeleteForm($typefonction);

        return $this->render('typefonction/show.html.twig', array(
            'typefonction' => $typefonction,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typefonction entity.
     *
     * @Route("/{slug}/edit", name="admin_typefonction_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typefonction $typefonction)
    {
        $deleteForm = $this->createDeleteForm($typefonction);
        $editForm = $this->createForm('AppBundle\Form\TypefonctionType', $typefonction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_typefonction_index');
        }

        return $this->render('typefonction/edit.html.twig', array(
            'typefonction' => $typefonction,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typefonction entity.
     *
     * @Route("/{id}", name="admin_typefonction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typefonction $typefonction)
    {
        $form = $this->createDeleteForm($typefonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typefonction);
            $em->flush();
        }

        return $this->redirectToRoute('admin_typefonction_index');
    }

    /**
     * Creates a form to delete a typefonction entity.
     *
     * @param Typefonction $typefonction The typefonction entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typefonction $typefonction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_typefonction_delete', array('id' => $typefonction->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
