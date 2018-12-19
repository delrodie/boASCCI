<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Regionale;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Regionale controller.
 *
 * @Route("admin/regionale")
 * @Security("has_role('ROLE_ADMIN')")
 */
class RegionaleController extends Controller
{
    /**
     * Lists all regionale entities.
     *
     * @Route("/", name="admin_regionale_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $regionales = $em->getRepository('AppBundle:Regionale')->findAll();

        return $this->render('regionale/index.html.twig', array(
            'regionales' => $regionales,
        ));
    }

    /**
     * Creates a new regionale entity.
     *
     * @Route("/new", name="admin_regionale_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $regionale = new Regionale();
        $form = $this->createForm('AppBundle\Form\RegionaleType', $regionale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($regionale);
            $em->flush();

            return $this->redirectToRoute('admin_regionale_show', array('slug' => $regionale->getSlug()));
        }

        return $this->render('regionale/new.html.twig', array(
            'regionale' => $regionale,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a regionale entity.
     *
     * @Route("/{slug}", name="admin_regionale_show")
     * @Method("GET")
     */
    public function showAction(Regionale $regionale)
    {
        $deleteForm = $this->createDeleteForm($regionale);

        return $this->render('regionale/show.html.twig', array(
            'regionale' => $regionale,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing regionale entity.
     *
     * @Route("/{slug}/edit", name="admin_regionale_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Regionale $regionale)
    {
        $deleteForm = $this->createDeleteForm($regionale);
        $editForm = $this->createForm('AppBundle\Form\RegionaleType', $regionale);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_regionale_show', array('slug' => $regionale->getSlug()));
        }

        return $this->render('regionale/edit.html.twig', array(
            'regionale' => $regionale,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a regionale entity.
     *
     * @Route("/{id}", name="admin_regionale_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Regionale $regionale)
    {
        $form = $this->createDeleteForm($regionale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($regionale);
            $em->flush();
        }

        return $this->redirectToRoute('admin_regionale_index');
    }

    /**
     * Creates a form to delete a regionale entity.
     *
     * @param Regionale $regionale The regionale entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Regionale $regionale)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_regionale_delete', array('id' => $regionale->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
