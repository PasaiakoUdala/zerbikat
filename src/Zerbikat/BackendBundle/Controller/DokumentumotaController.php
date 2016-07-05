<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Dokumentumota;
use Zerbikat\BackendBundle\Form\DokumentumotaType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Dokumentumota controller.
 *
 * @Route("/dokumentumota")
 */
class DokumentumotaController extends Controller
{
    /**
     * Lists all Dokumentumota entities.
     *
     * @Route("/", defaults={"page" = 1}, name="dokumentumota_index")
     * @Route("/page{page}", name="dokumentumota_index_paginated") 
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_KUDEAKETA')) {
            $em = $this->getDoctrine()->getManager();
            $dokumentumotas = $em->getRepository('BackendBundle:Dokumentumota')->findAll();

            $adapter = new ArrayAdapter($dokumentumotas);
            $pagerfanta = new Pagerfanta($adapter);            
            
            $deleteForms = array();
            foreach ($dokumentumotas as $dokumentumota) {
                $deleteForms[$dokumentumota->getId()] = $this->createDeleteForm($dokumentumota)->createView();
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

            return $this->render('dokumentumota/index.html.twig', array(
                'dokumentumotas' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,                
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Dokumentumota entity.
     *
     * @Route("/new", name="dokumentumota_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $dokumentumotum = new Dokumentumota();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\DokumentumotaType', $dokumentumotum);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($dokumentumotum);
                $em->flush();
//                return $this->redirectToRoute('dokumentumota_show', array('id' => $dokumentumotum->getId()));
                return $this->redirectToRoute('dokumentumota_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('dokumentumota/new.html.twig', array(
                'dokumentumotum' => $dokumentumotum,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Dokumentumota entity.
     *
     * @Route("/{id}", name="dokumentumota_show")
     * @Method("GET")
     */
    public function showAction(Dokumentumota $dokumentumotum)
    {
        $deleteForm = $this->createDeleteForm($dokumentumotum);

        return $this->render('dokumentumota/show.html.twig', array(
            'dokumentumotum' => $dokumentumotum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Dokumentumota entity.
     *
     * @Route("/{id}/edit", name="dokumentumota_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dokumentumota $dokumentumotum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($dokumentumotum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($dokumentumotum);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\DokumentumotaType', $dokumentumotum);
            $editForm->handleRequest($request);
    
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($dokumentumotum);
                $em->flush();
    
                return $this->redirectToRoute('dokumentumota_edit', array('id' => $dokumentumotum->getId()));
            }
    
            return $this->render('dokumentumota/edit.html.twig', array(
                'dokumentumotum' => $dokumentumotum,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Deletes a Dokumentumota entity.
     *
     * @Route("/{id}", name="dokumentumota_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dokumentumota $dokumentumotum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($dokumentumotum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($dokumentumotum);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($dokumentumotum);
                $em->flush();
            }
            return $this->redirectToRoute('dokumentumota_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');            
        }
    }

    /**
     * Creates a form to delete a Dokumentumota entity.
     *
     * @param Dokumentumota $dokumentumotum The Dokumentumota entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dokumentumota $dokumentumotum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dokumentumota_delete', array('id' => $dokumentumotum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
