<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Aurreikusi;
use Zerbikat\BackendBundle\Form\AurreikusiType;

/**
 * Aurreikusi controller.
 *
 * @Route("/aurreikusi")
 */
class AurreikusiController extends Controller
{
    /**
     * Lists all Aurreikusi entities.
     *
     * @Route("/", name="aurreikusi_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $aurreikusis = $em->getRepository('BackendBundle:Aurreikusi')->findAll();

        return $this->render('aurreikusi/index.html.twig', array(
            'aurreikusis' => $aurreikusis,
        ));
    }

    /**
     * Creates a new Aurreikusi entity.
     *
     * @Route("/new", name="aurreikusi_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $aurreikusi = new Aurreikusi();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\AurreikusiType', $aurreikusi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aurreikusi);
            $em->flush();

            return $this->redirectToRoute('aurreikusi_show', array('id' => $aurreikusi->getId()));
        }

        return $this->render('aurreikusi/new.html.twig', array(
            'aurreikusi' => $aurreikusi,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Aurreikusi entity.
     *
     * @Route("/{id}", name="aurreikusi_show")
     * @Method("GET")
     */
    public function showAction(Aurreikusi $aurreikusi)
    {
        $deleteForm = $this->createDeleteForm($aurreikusi);

        return $this->render('aurreikusi/show.html.twig', array(
            'aurreikusi' => $aurreikusi,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Aurreikusi entity.
     *
     * @Route("/{id}/edit", name="aurreikusi_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Aurreikusi $aurreikusi)
    {
        $deleteForm = $this->createDeleteForm($aurreikusi);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\AurreikusiType', $aurreikusi);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($aurreikusi);
            $em->flush();

            return $this->redirectToRoute('aurreikusi_edit', array('id' => $aurreikusi->getId()));
        }

        return $this->render('aurreikusi/edit.html.twig', array(
            'aurreikusi' => $aurreikusi,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Aurreikusi entity.
     *
     * @Route("/{id}", name="aurreikusi_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Aurreikusi $aurreikusi)
    {
        $form = $this->createDeleteForm($aurreikusi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($aurreikusi);
            $em->flush();
        }

        return $this->redirectToRoute('aurreikusi_index');
    }

    /**
     * Creates a form to delete a Aurreikusi entity.
     *
     * @param Aurreikusi $aurreikusi The Aurreikusi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Aurreikusi $aurreikusi)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aurreikusi_delete', array('id' => $aurreikusi->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}