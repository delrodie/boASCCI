<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Envol;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Envol controller.
 *
 * @Route("admin/envol")
 * @Security("has_role('ROLE_ADMIN')")
 */
class EnvolController extends Controller
{
    /**
     * Lists all envol entities.
     *
     * @Route("/", name="admin_envol_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $envols = $em->getRepository('AppBundle:Envol')->findAll();

        return $this->render('envol/index.html.twig', array(
            'envols' => $envols,
        ));
    }

    /**
     * Creates a new envol entity.
     *
     * @Route("/new", name="admin_envol_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $envol = new Envol();
        $form = $this->createForm('AppBundle\Form\EnvolType', $envol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($envol);
            $em->flush();

            return $this->redirectToRoute('admin_envol_show', array('slug' => $envol->getSlug()));
        }

        return $this->render('envol/new.html.twig', array(
            'envol' => $envol,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a envol entity.
     *
     * @Route("/{slug}", name="admin_envol_show")
     * @Method("GET")
     */
    public function showAction(Envol $envol)
    {
        $deleteForm = $this->createDeleteForm($envol);

        return $this->render('envol/show.html.twig', array(
            'envol' => $envol,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing envol entity.
     *
     * @Route("/{slug}/edit", name="admin_envol_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Envol $envol)
    {
        $deleteForm = $this->createDeleteForm($envol);
        $editForm = $this->createForm('AppBundle\Form\EnvolType', $envol);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_envol_show', array('slug' => $envol->getSlug()));
        }

        return $this->render('envol/edit.html.twig', array(
            'envol' => $envol,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a envol entity.
     *
     * @Route("/{id}", name="admin_envol_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Envol $envol)
    {
        $form = $this->createDeleteForm($envol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($envol);
            $em->flush();
        }

        return $this->redirectToRoute('admin_envol_index');
    }

    /**
     * Creates a form to delete a envol entity.
     *
     * @param Envol $envol The envol entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Envol $envol)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_envol_delete', array('id' => $envol->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
