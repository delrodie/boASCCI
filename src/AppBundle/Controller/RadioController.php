<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Radio;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Radio controller.
 *
 * @Route("admin/radio")
 * @Security("has_role('ROLE_ADMIN')")
 */
class RadioController extends Controller
{
    /**
     * Lists all radio entities.
     *
     * @Route("/", name="admin_radio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $radios = $em->getRepository('AppBundle:Radio')->findListDesc();

        return $this->render('radio/index.html.twig', array(
            'radios' => $radios,
        ));
    }

    /**
     * Creates a new radio entity.
     *
     * @Route("/new", name="admin_radio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $radio = new Radio();
        $form = $this->createForm('AppBundle\Form\RadioType', $radio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($radio);
            $em->flush();

            return $this->redirectToRoute('admin_radio_index');
        }

        return $this->render('radio/new.html.twig', array(
            'radio' => $radio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a radio entity.
     *
     * @Route("/{id}", name="admin_radio_show")
     * @Method("GET")
     */
    public function showAction(Radio $radio)
    {
        $deleteForm = $this->createDeleteForm($radio);

        return $this->render('radio/show.html.twig', array(
            'radio' => $radio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing radio entity.
     *
     * @Route("/{slug}/edit", name="admin_radio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Radio $radio)
    {
        $deleteForm = $this->createDeleteForm($radio);
        $editForm = $this->createForm('AppBundle\Form\RadioType', $radio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_radio_index');
        }

        return $this->render('radio/edit.html.twig', array(
            'radio' => $radio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a radio entity.
     *
     * @Route("/{id}", name="admin_radio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Radio $radio)
    {
        $form = $this->createDeleteForm($radio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($radio);
            $em->flush();
        }

        return $this->redirectToRoute('admin_radio_index');
    }

    /**
     * Creates a form to delete a radio entity.
     *
     * @param Radio $radio The radio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Radio $radio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_radio_delete', array('id' => $radio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
