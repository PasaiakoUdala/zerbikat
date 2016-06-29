<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Besteak1;
use Zerbikat\BackendBundle\Form\Besteak1Type;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Besteak1 controller.
 *
 * @Route("/besteak1")
 */
class Besteak1Controller extends Controller
{
    /**
     * Lists all Besteak1 entities.
     *
     * @Route("/", defaults={"page" = 1}, name="besteak1_index")
     * @Route("/page{page}", name="besteak1_index_paginated") 
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $besteak1s = $em->getRepository('BackendBundle:Besteak1')->findAll();

            $adapter = new ArrayAdapter($besteak1s);
            $pagerfanta = new Pagerfanta($adapter);            
            
            $deleteForms = array();
            foreach ($besteak1s as $besteak1) {
                $deleteForms[$besteak1->getId()] = $this->createDeleteForm($besteak1)->createView();
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
            
            return $this->render('besteak1/index.html.twig', array(
                'besteak1s' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,                
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Besteak1 entity.
     *
     * @Route("/new", name="besteak1_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $besteak1 = new Besteak1();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\Besteak1Type', $besteak1);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($besteak1);
                $em->flush();

//                return $this->redirectToRoute('besteak1_show', array('id' => $besteak1->getId()));
                return $this->redirectToRoute('besteak1_index');                
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('besteak1/new.html.twig', array(
                'besteak1' => $besteak1,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Besteak1 entity.
     *
     * @Route("/{id}", name="besteak1_show")
     * @Method("GET")
     */
    public function showAction(Besteak1 $besteak1)
    {
        $deleteForm = $this->createDeleteForm($besteak1);

        return $this->render('besteak1/show.html.twig', array(
            'besteak1' => $besteak1,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Besteak1 entity.
     *
     * @Route("/{id}/edit", name="besteak1_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Besteak1 $besteak1)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($besteak1->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($besteak1);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\Besteak1Type', $besteak1);
            $editForm->handleRequest($request);
    
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($besteak1);
                $em->flush();
    
                return $this->redirectToRoute('besteak1_edit', array('id' => $besteak1->getId()));
            }
    
            return $this->render('besteak1/edit.html.twig', array(
                'besteak1' => $besteak1,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Deletes a Besteak1 entity.
     *
     * @Route("/{id}", name="besteak1_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Besteak1 $besteak1)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($besteak1->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($besteak1);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($besteak1);
                $em->flush();
            }
            return $this->redirectToRoute('besteak1_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Creates a form to delete a Besteak1 entity.
     *
     * @param Besteak1 $besteak1 The Besteak1 entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Besteak1 $besteak1)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('besteak1_delete', array('id' => $besteak1->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
