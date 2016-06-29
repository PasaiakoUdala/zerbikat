<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Doklagun;
use Zerbikat\BackendBundle\Form\DoklagunType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

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
     * @Route("/", defaults={"page" = 1}, name="doklagun_index")
     * @Route("/page{page}", name="doklagun_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $em = $this->getDoctrine()->getManager();
            $doklaguns = $em->getRepository('BackendBundle:Doklagun')->findAll();

            $adapter = new ArrayAdapter($doklaguns);
            $pagerfanta = new Pagerfanta($adapter);

            $deleteForms = array();
            foreach ($doklaguns as $doklagun) {
                $deleteForms[$doklagun->getId()] = $this->createDeleteForm($doklagun)->createView();
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

            return $this->render('doklagun/index.html.twig', array(
                'doklaguns' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Doklagun entity.
     *
     * @Route("/new", name="doklagun_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $doklagun = new Doklagun();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\DoklagunType', $doklagun);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($doklagun);
                $em->flush();

//                return $this->redirectToRoute('doklagun_show', array('id' => $doklagun->getId()));
                return $this->redirectToRoute('doklagun_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('doklagun/new.html.twig', array(
                'doklagun' => $doklagun,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
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
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($doklagun->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
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
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Doklagun entity.
     *
     * @Route("/{id}", name="doklagun_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Doklagun $doklagun)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($doklagun->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($doklagun);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($doklagun);
                $em->flush();
            }

            return $this->redirectToRoute('doklagun_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
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
