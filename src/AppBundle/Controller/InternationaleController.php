<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Internationale;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Internationale controller.
 *
 * @Route("admin/internationale")
 * @Security("has_role('ROLE_ADMIN')")
 */
class InternationaleController extends Controller
{
    /**
     * Lists all internationale entities.
     *
     * @Route("/", name="admin_internationale_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $internationales = $em->getRepository('AppBundle:Internationale')->findAll();

        return $this->render('internationale/index.html.twig', array(
            'internationales' => $internationales,
        ));
    }

    /**
     * Creates a new internationale entity.
     *
     * @Route("/new", name="admin_internationale_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $internationale = new Internationale();
        $form = $this->createForm('AppBundle\Form\InternationaleType', $internationale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($internationale);
            $em->flush();

            return $this->redirectToRoute('admin_internationale_show', array('slug' => $internationale->getSlug()));
        }

        return $this->render('internationale/new.html.twig', array(
            'internationale' => $internationale,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a internationale entity.
     *
     * @Route("/{slug}", name="admin_internationale_show")
     * @Method("GET")
     */
    public function showAction(Internationale $internationale)
    {
        $deleteForm = $this->createDeleteForm($internationale);

        return $this->render('internationale/show.html.twig', array(
            'internationale' => $internationale,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing internationale entity.
     *
     * @Route("/{slug}/edit", name="admin_internationale_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Internationale $internationale)
    {
        $deleteForm = $this->createDeleteForm($internationale);
        $editForm = $this->createForm('AppBundle\Form\InternationaleType', $internationale);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_internationale_show', array('slug' => $internationale->getSlug()));
        }

        return $this->render('internationale/edit.html.twig', array(
            'internationale' => $internationale,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a internationale entity.
     *
     * @Route("/{id}", name="admin_internationale_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Internationale $internationale)
    {
        $form = $this->createDeleteForm($internationale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($internationale);
            $em->flush();
        }

        return $this->redirectToRoute('admin_internationale_index');
    }

    /**
     * Creates a form to delete a internationale entity.
     *
     * @param Internationale $internationale The internationale entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Internationale $internationale)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_internationale_delete', array('id' => $internationale->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
