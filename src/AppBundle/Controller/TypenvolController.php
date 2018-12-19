<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typenvol;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typenvol controller.
 *
 * @Route("admin/typenvol")
 * @Security("has_role('ROLE_ADMIN')")
 */
class TypenvolController extends Controller
{
    /**
     * Lists all typenvol entities.
     *
     * @Route("/", name="admin_typenvol_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typenvols = $em->getRepository('AppBundle:Typenvol')->findAll();

        return $this->render('typenvol/index.html.twig', array(
            'typenvols' => $typenvols,
        ));
    }

    /**
     * Creates a new typenvol entity.
     *
     * @Route("/new", name="admin_typenvol_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typenvol = new Typenvol();
        $form = $this->createForm('AppBundle\Form\TypenvolType', $typenvol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typenvol);
            $em->flush();

            return $this->redirectToRoute('admin_typenvol_index');
        }

        return $this->render('typenvol/new.html.twig', array(
            'typenvol' => $typenvol,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typenvol entity.
     *
     * @Route("/{id}", name="admin_typenvol_show")
     * @Method("GET")
     */
    public function showAction(Typenvol $typenvol)
    {
        $deleteForm = $this->createDeleteForm($typenvol);

        return $this->render('typenvol/show.html.twig', array(
            'typenvol' => $typenvol,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typenvol entity.
     *
     * @Route("/{slug}/edit", name="admin_typenvol_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typenvol $typenvol)
    {
        $deleteForm = $this->createDeleteForm($typenvol);
        $editForm = $this->createForm('AppBundle\Form\TypenvolType', $typenvol);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_typenvol_index');
        }

        return $this->render('typenvol/edit.html.twig', array(
            'typenvol' => $typenvol,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typenvol entity.
     *
     * @Route("/{id}", name="admin_typenvol_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typenvol $typenvol)
    {
        $form = $this->createDeleteForm($typenvol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typenvol);
            $em->flush();
        }

        return $this->redirectToRoute('admin_typenvol_index');
    }

    /**
     * Creates a form to delete a typenvol entity.
     *
     * @param Typenvol $typenvol The typenvol entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typenvol $typenvol)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_typenvol_delete', array('id' => $typenvol->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
