<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typerassemblement;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typerassemblement controller.
 *
 * @Route("admin/typerassemblement")
 * @Security("has_role('ROLE_ADMIN')")
 */
class TyperassemblementController extends Controller
{
    /**
     * Lists all typerassemblement entities.
     *
     * @Route("/", name="admin_typerassemblement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typerassemblements = $em->getRepository('AppBundle:Typerassemblement')->findAll();

        return $this->render('typerassemblement/index.html.twig', array(
            'typerassemblements' => $typerassemblements,
        ));
    }

    /**
     * Creates a new typerassemblement entity.
     *
     * @Route("/new", name="admin_typerassemblement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typerassemblement = new Typerassemblement();
        $form = $this->createForm('AppBundle\Form\TyperassemblementType', $typerassemblement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typerassemblement);
            $em->flush();

            return $this->redirectToRoute('admin_typerassemblement_index');
        }

        return $this->render('typerassemblement/new.html.twig', array(
            'typerassemblement' => $typerassemblement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typerassemblement entity.
     *
     * @Route("/{id}", name="admin_typerassemblement_show")
     * @Method("GET")
     */
    public function showAction(Typerassemblement $typerassemblement)
    {
        $deleteForm = $this->createDeleteForm($typerassemblement);

        return $this->render('typerassemblement/show.html.twig', array(
            'typerassemblement' => $typerassemblement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typerassemblement entity.
     *
     * @Route("/{slug}/edit", name="admin_typerassemblement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typerassemblement $typerassemblement)
    {
        $deleteForm = $this->createDeleteForm($typerassemblement);
        $editForm = $this->createForm('AppBundle\Form\TyperassemblementType', $typerassemblement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_typerassemblement_index');
        }

        return $this->render('typerassemblement/edit.html.twig', array(
            'typerassemblement' => $typerassemblement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typerassemblement entity.
     *
     * @Route("/{id}", name="admin_typerassemblement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typerassemblement $typerassemblement)
    {
        $form = $this->createDeleteForm($typerassemblement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typerassemblement);
            $em->flush();
        }

        return $this->redirectToRoute('admin_typerassemblement_index');
    }

    /**
     * Creates a form to delete a typerassemblement entity.
     *
     * @param Typerassemblement $typerassemblement The typerassemblement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typerassemblement $typerassemblement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_typerassemblement_delete', array('id' => $typerassemblement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
