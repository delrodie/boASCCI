<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Photo controller.
 *
 * @Route("admin/photo")
 * @Security("has_role('ROLE_ADMIN')")
 */
class PhotoController extends Controller
{
    /**
     * Lists all photo entities.
     *
     * @Route("/", name="admin_photo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('AppBundle:Photo')->findAll();

        return $this->render('photo/index.html.twig', array(
            'photos' => $photos,
        ));
    }

    /**
     * Creates a new photo entity.
     *
     * @Route("/new/{galerie}", name="admin_photo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $galerie)
    {
        $photo = new Photo();
        $form = $this->createForm('AppBundle\Form\PhotoType', $photo, array('galerie'=> $galerie));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            $this->addFlash('notice', 'Photo ajoutée avec succès!.');

            return $this->redirectToRoute('admin_photo_new', array('galerie' => $galerie));
        }

        $em = $this->getDoctrine()->getManager();
        $galerie = $em->getRepository('AppBundle:Galerie')->findOneBy(array('id' => $galerie));
        $photos = $em->getRepository('AppBundle:Photo')->findBy(array('galerie' => $galerie), array('id'=> 'DESC'));

        return $this->render('photo/new.html.twig', array(
            'photo' => $photo,
            'photos' => $photos,
            'galerie' => $galerie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a photo entity.
     *
     * @Route("/{id}", name="admin_photo_show")
     * @Method("GET")
     */
    public function showAction(Photo $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);

        return $this->render('photo/show.html.twig', array(
            'photo' => $photo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing photo entity.
     *
     * @Route("/{id}/edit/{galerie}", name="admin_photo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Photo $photo, $galerie)
    {
        $deleteForm = $this->createDeleteForm($photo);
        $editForm = $this->createForm('AppBundle\Form\PhotoType', $photo, array('galerie'=> $galerie));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_photo_new', array('galerie' => $galerie));
        }

        $em = $this->getDoctrine()->getManager();
        $galerie = $em->getRepository('AppBundle:Galerie')->findOneBy(array('id' => $galerie));
        $photos = $em->getRepository('AppBundle:Photo')->findBy(array('galerie' => $galerie), array('id'=> 'DESC'));

        return $this->render('photo/edit.html.twig', array(
            'photo' => $photo,
            'photos' => $photos,
            'galerie' => $galerie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a photo entity.
     *
     * @Route("/{id}", name="admin_photo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Photo $photo)
    {
        $form = $this->createDeleteForm($photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush();
        }

        return $this->redirectToRoute('admin_photo_index');
    }

    /**
     * Creates a form to delete a photo entity.
     *
     * @param Photo $photo The photo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Photo $photo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_photo_delete', array('id' => $photo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
