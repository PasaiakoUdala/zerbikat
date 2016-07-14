<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Kanala;
use Zerbikat\BackendBundle\Form\KanalaType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Kanala controller.
 *
 * @Route("/kanala")
 */
class KanalaController extends Controller
{
    /**
     * Lists all Kanala entities.
     *
     * @Route("/", defaults={"page" = 1}, name="kanala_index")
     * @Route("/page{page}", name="kanala_index_paginated") 
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_KUDEAKETA')) {
            $em = $this->getDoctrine()->getManager();
//            $kanalas = $em->getRepository('BackendBundle:Kanala')->findAll();
            $kanalas = $em->getRepository('BackendBundle:Kanala')
                ->findBy( array(), array('kanalmota'=>'ASC') );

            $adapter = new ArrayAdapter($kanalas);
            $pagerfanta = new Pagerfanta($adapter);
            
            $deleteForms = array();
            foreach ($kanalas as $kanala) {
                $deleteForms[$kanala->getId()] = $this->createDeleteForm($kanala)->createView();
            }

            try {
                $entities = $pagerfanta
                    // Le nombre maximum d'éléments par page
                    ->setMaxPerPage($this->getUser()->getUdala()->getOrrikatzea())
                    // Notre position actuelle (numéro de page)
                    ->setCurrentPage($page)
                    // On récupère nos entités via Pagerfanta,
                    // celui-ci s'occupe de limiter la requête en fonction de nos réglages.
                    ->getCurrentPageResults()
                ;
            } catch (\Pagerfanta\Exception\NotValidCurrentPageException $e) {
                throw $this->createNotFoundException("Orria ez da existitzen");
            }            
            
            return $this->render('kanala/index.html.twig', array(
                'kanalas' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Kanala entity.
     *
     * @Route("/new", name="kanala_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $kanala = new Kanala();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\KanalaType', $kanala);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($kanala);
                $em->flush();

//                return $this->redirectToRoute('kanala_show', array('id' => $kanala->getId()));
                return $this->redirectToRoute('kanala_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('kanala/new.html.twig', array(
                'kanala' => $kanala,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Kanala entity.
     *
     * @Route("/{id}", name="kanala_show")
     * @Method("GET")
     */
    public function showAction(Kanala $kanala)
    {
        $deleteForm = $this->createDeleteForm($kanala);

        return $this->render('kanala/show.html.twig', array(
            'kanala' => $kanala,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Kanala entity.
     *
     * @Route("/{id}/edit", name="kanala_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Kanala $kanala)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($kanala->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($kanala);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\KanalaType', $kanala);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($kanala);
                $em->flush();

                return $this->redirectToRoute('kanala_edit', array('id' => $kanala->getId()));
            }

            return $this->render('kanala/edit.html.twig', array(
                'kanala' => $kanala,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Kanala entity.
     *
     * @Route("/{id}", name="kanala_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Kanala $kanala)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($kanala->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {        
            $form = $this->createDeleteForm($kanala);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($kanala);
                $em->flush();
            }
            return $this->redirectToRoute('kanala_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Creates a form to delete a Kanala entity.
     *
     * @param Kanala $kanala The Kanala entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Kanala $kanala)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('kanala_delete', array('id' => $kanala->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
