<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BlockCamp;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Blockcamp controller.
 *
 * @Route("admin/blockcamp")
 * @Security("has_role('ROLE_ADMIN')")
 */
class BlockCampController extends Controller
{
    /**
     * Lists all blockCamp entities.
     *
     * @Route("/", name="admin_blockcamp_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blockCamps = $em->getRepository('AppBundle:BlockCamp')->findAll();

        return $this->render('blockcamp/index.html.twig', array(
            'blockCamps' => $blockCamps,
        ));
    }

    /**
     * Creates a new blockCamp entity.
     *
     * @Route("/new", name="admin_blockcamp_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blockCamp = new Blockcamp();
        $form = $this->createForm('AppBundle\Form\BlockCampType', $blockCamp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blockCamp);
            $em->flush();

            return $this->redirectToRoute('admin_blockcamp_index');
        }

        return $this->render('blockcamp/new.html.twig', array(
            'blockCamp' => $blockCamp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blockCamp entity.
     *
     * @Route("/{id}", name="admin_blockcamp_show")
     * @Method("GET")
     */
    public function showAction(BlockCamp $blockCamp)
    {
        $deleteForm = $this->createDeleteForm($blockCamp);

        return $this->render('blockcamp/show.html.twig', array(
            'blockCamp' => $blockCamp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blockCamp entity.
     *
     * @Route("/{id}/edit", name="admin_blockcamp_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlockCamp $blockCamp)
    {
        $deleteForm = $this->createDeleteForm($blockCamp);
        $editForm = $this->createForm('AppBundle\Form\BlockCampType', $blockCamp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_blockcamp_index');
        }

        return $this->render('blockcamp/edit.html.twig', array(
            'blockCamp' => $blockCamp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blockCamp entity.
     *
     * @Route("/{id}", name="admin_blockcamp_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlockCamp $blockCamp)
    {
        $form = $this->createDeleteForm($blockCamp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blockCamp);
            $em->flush();
        }

        return $this->redirectToRoute('admin_blockcamp_index');
    }

    /**
     * Creates a form to delete a blockCamp entity.
     *
     * @param BlockCamp $blockCamp The blockCamp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlockCamp $blockCamp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_blockcamp_delete', array('id' => $blockCamp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
