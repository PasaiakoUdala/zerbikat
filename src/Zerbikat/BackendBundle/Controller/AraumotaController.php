<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Araumota;
use Zerbikat\BackendBundle\Form\AraumotaType;

/**
 * Araumota controller.
 *
 * @Route("/araumota")
 */
class AraumotaController extends Controller
{
    /**
     * Lists all Araumota entities.
     *
     * @Route("/", name="araumota_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $araumotas = $em->getRepository('BackendBundle:Araumota')->findAll();

        return $this->render('araumota/index.html.twig', array(
            'araumotas' => $araumotas,
        ));
    }

    /**
     * Creates a new Araumota entity.
     *
     * @Route("/new", name="araumota_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $araumotum = new Araumota();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\AraumotaType', $araumotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($araumotum);
            $em->flush();

            return $this->redirectToRoute('araumota_show', array('id' => $araumotum->getId()));
        }

        return $this->render('araumota/new.html.twig', array(
            'araumotum' => $araumotum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Araumota entity.
     *
     * @Route("/{id}", name="araumota_show")
     * @Method("GET")
     */
    public function showAction(Araumota $araumotum)
    {
        $deleteForm = $this->createDeleteForm($araumotum);

        return $this->render('araumota/show.html.twig', array(
            'araumotum' => $araumotum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Araumota entity.
     *
     * @Route("/{id}/edit", name="araumota_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Araumota $araumotum)
    {
        $deleteForm = $this->createDeleteForm($araumotum);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\AraumotaType', $araumotum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($araumotum);
            $em->flush();

            return $this->redirectToRoute('araumota_edit', array('id' => $araumotum->getId()));
        }

        return $this->render('araumota/edit.html.twig', array(
            'araumotum' => $araumotum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Araumota entity.
     *
     * @Route("/{id}", name="araumota_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Araumota $araumotum)
    {
        $form = $this->createDeleteForm($araumotum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($araumotum);
            $em->flush();
        }

        return $this->redirectToRoute('araumota_index');
    }

    /**
     * Creates a form to delete a Araumota entity.
     *
     * @param Araumota $araumotum The Araumota entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Araumota $araumotum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('araumota_delete', array('id' => $araumotum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
