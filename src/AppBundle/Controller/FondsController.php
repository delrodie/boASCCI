<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fonds;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Fond controller.
 *
 * @Route("admin/fonds")
 */
class FondsController extends Controller
{
    /**
     * Lists all fond entities.
     *
     * @Route("/", name="admin_fonds_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fonds = $em->getRepository('AppBundle:Fonds')->findAll();

        return $this->render('fonds/index.html.twig', array(
            'fonds' => $fonds,
        ));
    }

    /**
     * Creates a new fond entity.
     *
     * @Route("/new", name="admin_fonds_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fond = new Fonds();
        $form = $this->createForm('AppBundle\Form\FondsType', $fond);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //ini_set('memory_limit', '1024M');
            $em->persist($fond);
            $em->flush();

            return $this->redirectToRoute('admin_fonds_show', ['id'=>$fond->getId()]);
        }

        return $this->render('fonds/new.html.twig', array(
            'fond' => $fond,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fond entity.
     *
     * @Route("/{id}", name="admin_fonds_show")
     * @Method("GET")
     */
    public function showAction(Fonds $fond)
    {
        $deleteForm = $this->createDeleteForm($fond); //dump($fond);die();

        return $this->render('fonds/show.html.twig', array(
            'fond' => $fond,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fond entity.
     *
     * @Route("/{id}/edit", name="admin_fonds_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fonds $fond)
    {
        $deleteForm = $this->createDeleteForm($fond);
        $editForm = $this->createForm('AppBundle\Form\FondsType', $fond);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_fonds_show', array('id' => $fond->getId()));
        }

        return $this->render('fonds/edit.html.twig', array(
            'fond' => $fond,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fond entity.
     *
     * @Route("/{id}", name="admin_fonds_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fonds $fond)
    {
        $form = $this->createDeleteForm($fond);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fond);
            $em->flush();
        }

        return $this->redirectToRoute('admin_fonds_index');
    }

    /**
     * Creates a form to delete a fond entity.
     *
     * @param Fonds $fond The fond entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fonds $fond)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_fonds_delete', array('id' => $fond->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
