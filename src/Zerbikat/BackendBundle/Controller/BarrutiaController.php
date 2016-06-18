<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Barrutia;
use Zerbikat\BackendBundle\Form\BarrutiaType;

/**
 * Barrutia controller.
 *
 * @Route("/barrutia")
 */
class BarrutiaController extends Controller
{
    /**
     * Lists all Barrutia entities.
     *
     * @Route("/", name="barrutia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $barrutias = $em->getRepository('BackendBundle:Barrutia')->findAll();
            return $this->render('barrutia/index.html.twig', array(
                'barrutias' => $barrutias,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a new Barrutia entity.
     *
     * @Route("/new", name="barrutia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $barrutium = new Barrutia();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\BarrutiaType', $barrutium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($barrutium);
            $em->flush();

            return $this->redirectToRoute('barrutia_show', array('id' => $barrutium->getId()));
        }

        return $this->render('barrutia/new.html.twig', array(
            'barrutium' => $barrutium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Barrutia entity.
     *
     * @Route("/{id}", name="barrutia_show")
     * @Method("GET")
     */
    public function showAction(Barrutia $barrutium)
    {
        $deleteForm = $this->createDeleteForm($barrutium);

        return $this->render('barrutia/show.html.twig', array(
            'barrutium' => $barrutium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Barrutia entity.
     *
     * @Route("/{id}/edit", name="barrutia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Barrutia $barrutium)
    {
        $deleteForm = $this->createDeleteForm($barrutium);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\BarrutiaType', $barrutium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($barrutium);
            $em->flush();

            return $this->redirectToRoute('barrutia_edit', array('id' => $barrutium->getId()));
        }

        return $this->render('barrutia/edit.html.twig', array(
            'barrutium' => $barrutium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Barrutia entity.
     *
     * @Route("/{id}", name="barrutia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Barrutia $barrutium)
    {
        $form = $this->createDeleteForm($barrutium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($barrutium);
            $em->flush();
        }

        return $this->redirectToRoute('barrutia_index');
    }

    /**
     * Creates a form to delete a Barrutia entity.
     *
     * @param Barrutia $barrutium The Barrutia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Barrutia $barrutium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('barrutia_delete', array('id' => $barrutium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
