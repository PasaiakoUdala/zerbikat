<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\IsiltasunAdministratiboa;
use Zerbikat\BackendBundle\Form\IsiltasunAdministratiboaType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * IsiltasunAdministratiboa controller.
 *
 * @Route("/isiltasunadministratiboa")
 */
class IsiltasunAdministratiboaController extends Controller
{
    /**
     * Lists all IsiltasunAdministratiboa entities.
     *
     * @Route("/", name="isiltasunadministratiboa_index")
     * @Route("/", defaults={"page" = 1}, name="isiltasunadministratiboa_index")
     * @Route("/page{page}", name="isiltasunadministratiboa_index_paginated")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_KUDEAKETA'))
        {
            $em = $this->getDoctrine()->getManager();
            $isiltasunAdministratiboas = $em->getRepository('BackendBundle:IsiltasunAdministratiboa')->findAll();

            $deleteForms = array();
            foreach ($isiltasunAdministratiboas as $isiltasunAdministratiboa) {
                $deleteForms[$isiltasunAdministratiboa->getId()] = $this->createDeleteForm($isiltasunAdministratiboa)->createView();
            }

            return $this->render('isiltasunadministratiboa/index.html.twig', array(
                'isiltasunAdministratiboas' => $isiltasunAdministratiboas,
                'deleteforms' => $deleteForms
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new IsiltasunAdministratiboa entity.
     *
     * @Route("/new", name="isiltasunadministratiboa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $isiltasunAdministratiboa = new IsiltasunAdministratiboa();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\IsiltasunAdministratiboaType', $isiltasunAdministratiboa);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($isiltasunAdministratiboa);
                $em->flush();

//                return $this->redirectToRoute('isiltasunadministratiboa_show', array('id' => $isiltasunAdministratiboa->getId()));
                return $this->redirectToRoute('isiltasunadministratiboa_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('isiltasunadministratiboa/new.html.twig', array(
                'isiltasunAdministratiboa' => $isiltasunAdministratiboa,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a IsiltasunAdministratiboa entity.
     *
     * @Route("/{id}", name="isiltasunadministratiboa_show")
     * @Method("GET")
     */
    public function showAction(IsiltasunAdministratiboa $isiltasunAdministratiboa)
    {
        $deleteForm = $this->createDeleteForm($isiltasunAdministratiboa);

        return $this->render('isiltasunadministratiboa/show.html.twig', array(
            'isiltasunAdministratiboa' => $isiltasunAdministratiboa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing IsiltasunAdministratiboa entity.
     *
     * @Route("/{id}/edit", name="isiltasunadministratiboa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, IsiltasunAdministratiboa $isiltasunAdministratiboa)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($isiltasunAdministratiboa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($isiltasunAdministratiboa);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\IsiltasunAdministratiboaType', $isiltasunAdministratiboa);
            $editForm->handleRequest($request);
    
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($isiltasunAdministratiboa);
                $em->flush();
    
                return $this->redirectToRoute('isiltasunadministratiboa_edit', array('id' => $isiltasunAdministratiboa->getId()));
            }
    
            return $this->render('isiltasunadministratiboa/edit.html.twig', array(
                'isiltasunAdministratiboa' => $isiltasunAdministratiboa,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Deletes a IsiltasunAdministratiboa entity.
     *
     * @Route("/{id}", name="isiltasunadministratiboa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, IsiltasunAdministratiboa $isiltasunAdministratiboa)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($isiltasunAdministratiboa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($isiltasunAdministratiboa);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($isiltasunAdministratiboa);
                $em->flush();
            }
            return $this->redirectToRoute('isiltasunadministratiboa_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a IsiltasunAdministratiboa entity.
     *
     * @param IsiltasunAdministratiboa $isiltasunAdministratiboa The IsiltasunAdministratiboa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(IsiltasunAdministratiboa $isiltasunAdministratiboa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('isiltasunadministratiboa_delete', array('id' => $isiltasunAdministratiboa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
