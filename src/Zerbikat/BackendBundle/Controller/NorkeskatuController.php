<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Norkeskatu;
use Zerbikat\BackendBundle\Form\NorkeskatuType;

/**
 * Norkeskatu controller.
 *
 * @Route("/norkeskatu")
 */
class NorkeskatuController extends Controller
{
    /**
     * Lists all Norkeskatu entities.
     *
     * @Route("/", name="norkeskatu_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $norkeskatus = $em->getRepository('BackendBundle:Norkeskatu')->findAll();
            return $this->render('norkeskatu/index.html.twig', array(
                'norkeskatus' => $norkeskatus,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a new Norkeskatu entity.
     *
     * @Route("/new", name="norkeskatu_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $norkeskatu = new Norkeskatu();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\NorkeskatuType', $norkeskatu);
            $form->handleRequest($request);

            $form->getData()->setUdala($this->getUser()->getUdala());
            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($norkeskatu);
                $em->flush();

                return $this->redirectToRoute('norkeskatu_show', array('id' => $norkeskatu->getId()));
            }

            return $this->render('norkeskatu/new.html.twig', array(
                'norkeskatu' => $norkeskatu,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Finds and displays a Norkeskatu entity.
     *
     * @Route("/{id}", name="norkeskatu_show")
     * @Method("GET")
     */
    public function showAction(Norkeskatu $norkeskatu)
    {
        $deleteForm = $this->createDeleteForm($norkeskatu);

        return $this->render('norkeskatu/show.html.twig', array(
            'norkeskatu' => $norkeskatu,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Norkeskatu entity.
     *
     * @Route("/{id}/edit", name="norkeskatu_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Norkeskatu $norkeskatu)
    {
        $deleteForm = $this->createDeleteForm($norkeskatu);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\NorkeskatuType', $norkeskatu);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($norkeskatu);
            $em->flush();

            return $this->redirectToRoute('norkeskatu_edit', array('id' => $norkeskatu->getId()));
        }

        return $this->render('norkeskatu/edit.html.twig', array(
            'norkeskatu' => $norkeskatu,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Norkeskatu entity.
     *
     * @Route("/{id}", name="norkeskatu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Norkeskatu $norkeskatu)
    {
        $form = $this->createDeleteForm($norkeskatu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($norkeskatu);
            $em->flush();
        }

        return $this->redirectToRoute('norkeskatu_index');
    }

    /**
     * Creates a form to delete a Norkeskatu entity.
     *
     * @param Norkeskatu $norkeskatu The Norkeskatu entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Norkeskatu $norkeskatu)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('norkeskatu_delete', array('id' => $norkeskatu->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
