<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Datuenbabesa;
use Zerbikat\BackendBundle\Form\DatuenbabesaType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Datuenbabesa controller.
 *
 * @Route("/datuenbabesa")
 */
class DatuenbabesaController extends Controller
{
    /**
     * Lists all Datuenbabesa entities.
     *
     * @Route("/", defaults={"page" = 1}, name="datuenbabesa_index")
     * @Route("/page{page}", name="datuenbabesa_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_KUDEAKETA')) {
            $em = $this->getDoctrine()->getManager();
            $datuenbabesas = $em->getRepository('BackendBundle:Datuenbabesa')
                ->findBy( array(), array('kodea'=>'ASC') );

            $deleteForms = array();
            foreach ($datuenbabesas as $datuenbabesa) {
                $deleteForms[$datuenbabesa->getId()] = $this->createDeleteForm($datuenbabesa)->createView();
            }

            return $this->render('datuenbabesa/index.html.twig', array(
                'datuenbabesas' => $datuenbabesas,
                'deleteforms' => $deleteForms
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Datuenbabesa entity.
     *
     * @Route("/new", name="datuenbabesa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) 
        {
            $datuenbabesa = new Datuenbabesa();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\DatuenbabesaType', $datuenbabesa);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());
            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($datuenbabesa);
                $em->flush();
    
//                return $this->redirectToRoute('datuenbabesa_show', array('id' => $datuenbabesa->getId()));
                return $this->redirectToRoute('datuenbabesa_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }
    
            return $this->render('datuenbabesa/new.html.twig', array(
                'datuenbabesa' => $datuenbabesa,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Datuenbabesa entity.
     *
     * @Route("/{id}", name="datuenbabesa_show")
     * @Method("GET")
     */
    public function showAction(Datuenbabesa $datuenbabesa)
    {
        $deleteForm = $this->createDeleteForm($datuenbabesa);

        return $this->render('datuenbabesa/show.html.twig', array(
            'datuenbabesa' => $datuenbabesa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Datuenbabesa entity.
     *
     * @Route("/{id}/edit", name="datuenbabesa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Datuenbabesa $datuenbabesa)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($datuenbabesa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($datuenbabesa);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\DatuenbabesaType', $datuenbabesa);
            $editForm->handleRequest($request);
    
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($datuenbabesa);
                $em->flush();
    
                return $this->redirectToRoute('datuenbabesa_edit', array('id' => $datuenbabesa->getId()));
            }
    
            return $this->render('datuenbabesa/edit.html.twig', array(
                'datuenbabesa' => $datuenbabesa,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Deletes a Datuenbabesa entity.
     *
     * @Route("/{id}", name="datuenbabesa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Datuenbabesa $datuenbabesa)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($datuenbabesa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($datuenbabesa);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($datuenbabesa);
                $em->flush();
            }
            return $this->redirectToRoute('datuenbabesa_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Datuenbabesa entity.
     *
     * @param Datuenbabesa $datuenbabesa The Datuenbabesa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Datuenbabesa $datuenbabesa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datuenbabesa_delete', array('id' => $datuenbabesa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
