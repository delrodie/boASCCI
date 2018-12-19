<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pedagogie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pedagogie controller.
 *
 * @Route("admin/pedagogie")
 * @Security("has_role('ROLE_ADMIN')")
 */
class PedagogieController extends Controller
{
    /**
     * Lists all pedagogie entities.
     *
     * @Route("/", name="admin_pedagogie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pedagogies = $em->getRepository('AppBundle:Pedagogie')->findAll();

        return $this->render('pedagogie/index.html.twig', array(
            'pedagogies' => $pedagogies,
        ));
    }

    /**
     * Creates a new pedagogie entity.
     *
     * @Route("/new", name="admin_pedagogie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pedagogie = new Pedagogie();
        $form = $this->createForm('AppBundle\Form\PedagogieType', $pedagogie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pedagogie);
            $em->flush();

            return $this->redirectToRoute('admin_pedagogie_show', array('slug' => $pedagogie->getSlug()));
        }

        return $this->render('pedagogie/new.html.twig', array(
            'pedagogie' => $pedagogie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pedagogie entity.
     *
     * @Route("/{slug}", name="admin_pedagogie_show")
     * @Method("GET")
     */
    public function showAction(Pedagogie $pedagogie)
    {
        $deleteForm = $this->createDeleteForm($pedagogie);

        return $this->render('pedagogie/show.html.twig', array(
            'pedagogie' => $pedagogie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pedagogie entity.
     *
     * @Route("/{slug}/edit", name="admin_pedagogie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pedagogie $pedagogie)
    {
        $deleteForm = $this->createDeleteForm($pedagogie);
        $editForm = $this->createForm('AppBundle\Form\PedagogieType', $pedagogie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_pedagogie_show', array('slug' => $pedagogie->getSlug()));
        }

        return $this->render('pedagogie/edit.html.twig', array(
            'pedagogie' => $pedagogie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pedagogie entity.
     *
     * @Route("/{id}", name="admin_pedagogie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pedagogie $pedagogie)
    {
        $form = $this->createDeleteForm($pedagogie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pedagogie);
            $em->flush();
        }

        return $this->redirectToRoute('admin_pedagogie_index');
    }

    /**
     * Creates a form to delete a pedagogie entity.
     *
     * @param Pedagogie $pedagogie The pedagogie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pedagogie $pedagogie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pedagogie_delete', array('id' => $pedagogie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
