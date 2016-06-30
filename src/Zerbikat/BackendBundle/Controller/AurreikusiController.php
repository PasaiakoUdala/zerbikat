<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Aurreikusi;
use Zerbikat\BackendBundle\Form\AurreikusiType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

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
     * @Route("/", defaults={"page" = 1}, name="aurreikusi_index")
     * @Route("/page{page}", name="aurreikusi_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $em = $this->getDoctrine()->getManager();
            $aurreikusis = $em->getRepository('BackendBundle:Aurreikusi')->findAll();

            $adapter = new ArrayAdapter($aurreikusis);
            $pagerfanta = new Pagerfanta($adapter);

            $deleteForms = array();
            foreach ($aurreikusis as $aurreikusi) {
                $deleteForms[$aurreikusi->getId()] = $this->createDeleteForm($aurreikusi)->createView();
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

            return $this->render('aurreikusi/index.html.twig', array(
                'aurreikusis' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,
            ));
        }else
        {
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');            
        }
    }

    /**
     * Creates a new Aurreikusi entity.
     *
     * @Route("/new", name="aurreikusi_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $aurreikusi = new Aurreikusi();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\AurreikusiType', $aurreikusi);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($aurreikusi);
                $em->flush();

//                return $this->redirectToRoute('aurreikusi_show', array('id' => $aurreikusi->getId()));
                return $this->redirectToRoute('aurreikusi_index');                
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('aurreikusi/new.html.twig', array(
                'aurreikusi' => $aurreikusi,
                'form' => $form->createView(),
            ));
        }else
        {
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');
        }
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
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($aurreikusi->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
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
        }else
        {
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Aurreikusi entity.
     *
     * @Route("/{id}", name="aurreikusi_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Aurreikusi $aurreikusi)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($aurreikusi->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($aurreikusi);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($aurreikusi);
                $em->flush();
            }
            return $this->redirectToRoute('aurreikusi_index');
        }else
        {
            //baimenik ez
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');            
        }
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
