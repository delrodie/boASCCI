<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Jeu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Jeu controller.
 *
 * @Route("admin/jeu")
 */
class JeuController extends Controller
{
    /**
     * Lists all jeu entities.
     *
     * @Route("/", name="admin_jeu_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $jeus = $em->getRepository('AppBundle:Jeu')->findAll();

        return $this->render('jeu/index.html.twig', array(
            'jeus' => $jeus,
        ));
    }

    /**
     * Creates a new jeu entity.
     *
     * @Route("/new", name="admin_jeu_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $jeu = new Jeu();
        $form = $this->createForm('AppBundle\Form\JeuType', $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jeu);
            $em->flush();

            return $this->redirectToRoute('admin_jeu_show', array('slug' => $jeu->getSlug()));
        }

        return $this->render('jeu/new.html.twig', array(
            'jeu' => $jeu,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a jeu entity.
     *
     * @Route("/{slug}", name="admin_jeu_show")
     * @Method("GET")
     */
    public function showAction(Jeu $jeu)
    {
        $deleteForm = $this->createDeleteForm($jeu);

        return $this->render('jeu/show.html.twig', array(
            'jeu' => $jeu,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing jeu entity.
     *
     * @Route("/{slug}/edit", name="admin_jeu_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Jeu $jeu)
    {
        $deleteForm = $this->createDeleteForm($jeu);
        $editForm = $this->createForm('AppBundle\Form\JeuType', $jeu);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_jeu_edit', array('slug' => $jeu->getSlug()));
        }

        return $this->render('jeu/edit.html.twig', array(
            'jeu' => $jeu,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a jeu entity.
     *
     * @Route("/{id}", name="admin_jeu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Jeu $jeu)
    {
        $form = $this->createDeleteForm($jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($jeu);
            $em->flush();
        }

        return $this->redirectToRoute('admin_jeu_index');
    }

    /**
     * Creates a form to delete a jeu entity.
     *
     * @param Jeu $jeu The jeu entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Jeu $jeu)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_jeu_delete', array('id' => $jeu->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
