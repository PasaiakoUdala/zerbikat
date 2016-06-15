<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Doklagun;
use Zerbikat\BackendBundle\Form\DoklagunType;

/**
 * Doklagun controller.
 *
 * @Route("/doklagun")
 */
class DoklagunController extends Controller
{
    /**
     * Lists all Doklagun entities.
     *
     * @Route("/", name="doklagun_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $doklaguns = $em->getRepository('BackendBundle:Doklagun')->findAll();

        return $this->render('doklagun/index.html.twig', array(
            'doklaguns' => $doklaguns,
        ));
    }

    /**
     * Creates a new Doklagun entity.
     *
     * @Route("/new", name="doklagun_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $doklagun = new Doklagun();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\DoklagunType', $doklagun);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($doklagun);
            $em->flush();

            return $this->redirectToRoute('doklagun_show', array('id' => $doklagun->getId()));
        }

        return $this->render('doklagun/new.html.twig', array(
            'doklagun' => $doklagun,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Doklagun entity.
     *
     * @Route("/{id}", name="doklagun_show")
     * @Method("GET")
     */
    public function showAction(Doklagun $doklagun)
    {
        $deleteForm = $this->createDeleteForm($doklagun);

        return $this->render('doklagun/show.html.twig', array(
            'doklagun' => $doklagun,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Doklagun entity.
     *
     * @Route("/{id}/edit", name="doklagun_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Doklagun $doklagun)
    {
        $deleteForm = $this->createDeleteForm($doklagun);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\DoklagunType', $doklagun);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($doklagun);
            $em->flush();

            return $this->redirectToRoute('doklagun_edit', array('id' => $doklagun->getId()));
        }

        return $this->render('doklagun/edit.html.twig', array(
            'doklagun' => $doklagun,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Doklagun entity.
     *
     * @Route("/{id}", name="doklagun_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Doklagun $doklagun)
    {
        $form = $this->createDeleteForm($doklagun);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($doklagun);
            $em->flush();
        }

        return $this->redirectToRoute('doklagun_index');
    }

    /**
     * Creates a form to delete a Doklagun entity.
     *
     * @param Doklagun $doklagun The Doklagun entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Doklagun $doklagun)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('doklagun_delete', array('id' => $doklagun->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
