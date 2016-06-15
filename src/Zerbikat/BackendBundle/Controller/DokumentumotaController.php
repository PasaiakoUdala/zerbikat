<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Dokumentumota;
use Zerbikat\BackendBundle\Form\DokumentumotaType;

/**
 * Dokumentumota controller.
 *
 * @Route("/dokumentumota")
 */
class DokumentumotaController extends Controller
{
    /**
     * Lists all Dokumentumota entities.
     *
     * @Route("/", name="dokumentumota_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dokumentumotas = $em->getRepository('BackendBundle:Dokumentumota')->findAll();

        return $this->render('dokumentumota/index.html.twig', array(
            'dokumentumotas' => $dokumentumotas,
        ));
    }

    /**
     * Creates a new Dokumentumota entity.
     *
     * @Route("/new", name="dokumentumota_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dokumentumotum = new Dokumentumota();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\DokumentumotaType', $dokumentumotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dokumentumotum);
            $em->flush();

            return $this->redirectToRoute('dokumentumota_show', array('id' => $dokumentumotum->getId()));
        }

        return $this->render('dokumentumota/new.html.twig', array(
            'dokumentumotum' => $dokumentumotum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Dokumentumota entity.
     *
     * @Route("/{id}", name="dokumentumota_show")
     * @Method("GET")
     */
    public function showAction(Dokumentumota $dokumentumotum)
    {
        $deleteForm = $this->createDeleteForm($dokumentumotum);

        return $this->render('dokumentumota/show.html.twig', array(
            'dokumentumotum' => $dokumentumotum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Dokumentumota entity.
     *
     * @Route("/{id}/edit", name="dokumentumota_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dokumentumota $dokumentumotum)
    {
        $deleteForm = $this->createDeleteForm($dokumentumotum);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\DokumentumotaType', $dokumentumotum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dokumentumotum);
            $em->flush();

            return $this->redirectToRoute('dokumentumota_edit', array('id' => $dokumentumotum->getId()));
        }

        return $this->render('dokumentumota/edit.html.twig', array(
            'dokumentumotum' => $dokumentumotum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Dokumentumota entity.
     *
     * @Route("/{id}", name="dokumentumota_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dokumentumota $dokumentumotum)
    {
        $form = $this->createDeleteForm($dokumentumotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dokumentumotum);
            $em->flush();
        }

        return $this->redirectToRoute('dokumentumota_index');
    }

    /**
     * Creates a form to delete a Dokumentumota entity.
     *
     * @param Dokumentumota $dokumentumotum The Dokumentumota entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dokumentumota $dokumentumotum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dokumentumota_delete', array('id' => $dokumentumotum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
