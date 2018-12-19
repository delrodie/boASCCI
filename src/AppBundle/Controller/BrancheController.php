<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Branche;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Branche controller.
 *
 * @Route("admin/branche")
 * @Security("has_role('ROLE_ADMIN')")
 */
class BrancheController extends Controller
{
    /**
     * Lists all branche entities.
     *
     * @Route("/", name="admin_branche_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $branches = $em->getRepository('AppBundle:Branche')->findAll();

        return $this->render('branche/index.html.twig', array(
            'branches' => $branches,
        ));
    }

    /**
     * Creates a new branche entity.
     *
     * @Route("/new", name="admin_branche_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $branche = new Branche();
        $form = $this->createForm('AppBundle\Form\BrancheType', $branche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($branche);
            $em->flush();

            return $this->redirectToRoute('admin_branche_index');
        }

        return $this->render('branche/new.html.twig', array(
            'branche' => $branche,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a branche entity.
     *
     * @Route("/{id}", name="admin_branche_show")
     * @Method("GET")
     */
    public function showAction(Branche $branche)
    {
        $deleteForm = $this->createDeleteForm($branche);

        return $this->render('branche/show.html.twig', array(
            'branche' => $branche,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing branche entity.
     *
     * @Route("/{slug}/edit", name="admin_branche_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Branche $branche)
    {
        $deleteForm = $this->createDeleteForm($branche);
        $editForm = $this->createForm('AppBundle\Form\BrancheType', $branche);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_branche_index');
        }

        return $this->render('branche/edit.html.twig', array(
            'branche' => $branche,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a branche entity.
     *
     * @Route("/{id}", name="admin_branche_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Branche $branche)
    {
        $form = $this->createDeleteForm($branche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($branche);
            $em->flush();
        }

        return $this->redirectToRoute('admin_branche_index');
    }

    /**
     * Creates a form to delete a branche entity.
     *
     * @param Branche $branche The branche entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Branche $branche)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_branche_delete', array('id' => $branche->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
