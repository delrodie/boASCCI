<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typinfos;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typinfo controller.
 *
 * @Route("admin/typinfos")
 * @Security("has_role('ROLE_ADMIN')")
 */
class TypinfosController extends Controller
{
    /**
     * Lists all typinfo entities.
     *
     * @Route("/", name="admin_typinfos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typinfos = $em->getRepository('AppBundle:Typinfos')->findAll();

        return $this->render('typinfos/index.html.twig', array(
            'typinfos' => $typinfos,
        ));
    }

    /**
     * Creates a new typinfo entity.
     *
     * @Route("/new", name="admin_typinfos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typinfo = new Typinfos();
        $form = $this->createForm('AppBundle\Form\TypinfosType', $typinfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typinfo);
            $em->flush();

            return $this->redirectToRoute('admin_typinfos_index');
        }

        return $this->render('typinfos/new.html.twig', array(
            'typinfo' => $typinfo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typinfo entity.
     *
     * @Route("/{id}", name="admin_typinfos_show")
     * @Method("GET")
     */
    public function showAction(Typinfos $typinfo)
    {
        $deleteForm = $this->createDeleteForm($typinfo);

        return $this->render('typinfos/show.html.twig', array(
            'typinfo' => $typinfo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typinfo entity.
     *
     * @Route("/{slug}/edit", name="admin_typinfos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typinfos $typinfo)
    {
        $deleteForm = $this->createDeleteForm($typinfo);
        $editForm = $this->createForm('AppBundle\Form\TypinfosType', $typinfo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_typinfos_index');
        }

        return $this->render('typinfos/edit.html.twig', array(
            'typinfo' => $typinfo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typinfo entity.
     *
     * @Route("/{id}", name="admin_typinfos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typinfos $typinfo)
    {
        $form = $this->createDeleteForm($typinfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typinfo);
            $em->flush();
        }

        return $this->redirectToRoute('admin_typinfos_index');
    }

    /**
     * Creates a form to delete a typinfo entity.
     *
     * @param Typinfos $typinfo The typinfo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typinfos $typinfo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_typinfos_delete', array('id' => $typinfo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
