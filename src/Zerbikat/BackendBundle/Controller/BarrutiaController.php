<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Barrutia;
use Zerbikat\BackendBundle\Form\BarrutiaType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

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
     * @Route("/", defaults={"page" = 1}, name="barrutia_index")
     * @Route("/page{page}", name="barrutia_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $barrutias = $em->getRepository('BackendBundle:Barrutia')->findAll();

            $adapter = new ArrayAdapter($barrutias);
            $pagerfanta = new Pagerfanta($adapter);

            $deleteForms = array();
            foreach ($barrutias as $barrutia) {
                $deleteForms[$barrutia->getId()] = $this->createDeleteForm($barrutia)->createView();
            }

            try {
                $entities = $pagerfanta
                    // Le nombre maximum d'éléments par page
                    ->setMaxPerPage(20)
                    // Notre position actuelle (numéro de page)
                    ->setCurrentPage($page)
                    // On récupère nos entités via Pagerfanta,
                    // celui-ci s'occupe de limiter la requête en fonction de nos réglages.
                    ->getCurrentPageResults()
                ;
            } catch (\Pagerfanta\Exception\NotValidCurrentPageException $e) {
                throw $this->createNotFoundException("Orria ez da existitzen");
            }

            return $this->render('barrutia/index.html.twig', array(
                'barrutias' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
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
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $barrutium = new Barrutia();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\BarrutiaType', $barrutium);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($barrutium);
                $em->flush();

//                return $this->redirectToRoute('barrutia_show', array('id' => $barrutium->getId()));
                return $this->redirectToRoute('barrutia_index');

            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('barrutia/new.html.twig', array(
                'barrutium' => $barrutium,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
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
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($barrutium->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
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
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Barrutia entity.
     *
     * @Route("/{id}", name="barrutia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Barrutia $barrutium)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($barrutium->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($barrutium);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($barrutium);
                $em->flush();
            }
            return $this->redirectToRoute('barrutia_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }            
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
