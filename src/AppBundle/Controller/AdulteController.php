<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Adulte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Adulte controller.
 *
 * @Route("admin/adulte")
 */
class AdulteController extends Controller
{
    /**
     * Lists all adulte entities.
     *
     * @Route("/", name="admin_adulte_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $adultes = $em->getRepository('AppBundle:Adulte')->findAll();

        return $this->render('adulte/index.html.twig', array(
            'adultes' => $adultes,
        ));
    }

    /**
     * Creates a new adulte entity.
     *
     * @Route("/new", name="admin_adulte_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $adulte = new Adulte();
        $form = $this->createForm('AppBundle\Form\AdulteType', $adulte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($adulte);
            $em->flush();

            return $this->redirectToRoute('admin_adulte_show', array('slug' => $adulte->getSlug()));
        }

        return $this->render('adulte/new.html.twig', array(
            'adulte' => $adulte,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a adulte entity.
     *
     * @Route("/{slug}", name="admin_adulte_show")
     * @Method("GET")
     */
    public function showAction(Adulte $adulte)
    {
        $deleteForm = $this->createDeleteForm($adulte);

        return $this->render('adulte/show.html.twig', array(
            'adulte' => $adulte,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing adulte entity.
     *
     * @Route("/{slug}/edit", name="admin_adulte_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Adulte $adulte)
    {
        $deleteForm = $this->createDeleteForm($adulte);
        $editForm = $this->createForm('AppBundle\Form\AdulteType', $adulte);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_adulte_show', array('slug' => $adulte->getSlug()));
        }

        return $this->render('adulte/edit.html.twig', array(
            'adulte' => $adulte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a adulte entity.
     *
     * @Route("/{id}", name="admin_adulte_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Adulte $adulte)
    {
        $form = $this->createDeleteForm($adulte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($adulte);
            $em->flush();
        }

        return $this->redirectToRoute('admin_adulte_index');
    }

    /**
     * Creates a form to delete a adulte entity.
     *
     * @param Adulte $adulte The adulte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Adulte $adulte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_adulte_delete', array('id' => $adulte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
