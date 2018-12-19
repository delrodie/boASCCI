<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rassemblement;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Rassemblement controller.
 *
 * @Route("admin/rassemblement")
 * @Security("has_role('ROLE_ADMIN')")
 */
class RassemblementController extends Controller
{
    /**
     * Lists all rassemblement entities.
     *
     * @Route("/", name="admin_rassemblement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rassemblements = $em->getRepository('AppBundle:Rassemblement')->findAll();

        return $this->render('rassemblement/index.html.twig', array(
            'rassemblements' => $rassemblements,
        ));
    }

    /**
     * Creates a new rassemblement entity.
     *
     * @Route("/new", name="admin_rassemblement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rassemblement = new Rassemblement();
        $form = $this->createForm('AppBundle\Form\RassemblementType', $rassemblement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rassemblement);
            $em->flush();

            return $this->redirectToRoute('admin_rassemblement_show', array('slug' => $rassemblement->getSlug()));
        }

        return $this->render('rassemblement/new.html.twig', array(
            'rassemblement' => $rassemblement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rassemblement entity.
     *
     * @Route("/{slug}", name="admin_rassemblement_show")
     * @Method("GET")
     */
    public function showAction(Rassemblement $rassemblement)
    {
        $deleteForm = $this->createDeleteForm($rassemblement);

        return $this->render('rassemblement/show.html.twig', array(
            'rassemblement' => $rassemblement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rassemblement entity.
     *
     * @Route("/{slug}/edit", name="admin_rassemblement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rassemblement $rassemblement)
    {
        $deleteForm = $this->createDeleteForm($rassemblement);
        $editForm = $this->createForm('AppBundle\Form\RassemblementType', $rassemblement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_rassemblement_show', array('slug' => $rassemblement->getSlug()));
        }

        return $this->render('rassemblement/edit.html.twig', array(
            'rassemblement' => $rassemblement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rassemblement entity.
     *
     * @Route("/{id}", name="admin_rassemblement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rassemblement $rassemblement)
    {
        $form = $this->createDeleteForm($rassemblement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rassemblement);
            $em->flush();
        }

        return $this->redirectToRoute('admin_rassemblement_index');
    }

    /**
     * Creates a form to delete a rassemblement entity.
     *
     * @param Rassemblement $rassemblement The rassemblement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rassemblement $rassemblement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_rassemblement_delete', array('id' => $rassemblement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
