<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Kanalmota;
use Zerbikat\BackendBundle\Form\KanalmotaType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Kanalmota controller.
 *
 * @Route("/kanalmota")
 */
class KanalmotaController extends Controller
{
    /**
     * Lists all Kanalmota entities.
     *
     * @Route("/", defaults={"page" = 1}, name="kanalmota_index")
     * @Route("/page{page}", name="kanalmota_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_KUDEAKETA')) {
            $em = $this->getDoctrine()->getManager();
            $kanalmotas = $em->getRepository('BackendBundle:Kanalmota')->findAll();

            $adapter = new ArrayAdapter($kanalmotas);
            $pagerfanta = new Pagerfanta($adapter);

            $deleteForms = array();
            foreach ($kanalmotas as $kanalmota) {
                $deleteForms[$kanalmota->getId()] = $this->createDeleteForm($kanalmota)->createView();
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

            return $this->render('kanalmota/index.html.twig', array(
                'kanalmotas' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Kanalmota entity.
     *
     * @Route("/new", name="kanalmota_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $kanalmotum = new Kanalmota();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\KanalmotaType', $kanalmotum);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($kanalmotum);
                $em->flush();

//                return $this->redirectToRoute('kanalmota_show', array('id' => $kanalmotum->getId()));
                return $this->redirectToRoute('kanalmota_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('kanalmota/new.html.twig', array(
                'kanalmotum' => $kanalmotum,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Kanalmota entity.
     *
     * @Route("/{id}", name="kanalmota_show")
     * @Method("GET")
     */
    public function showAction(Kanalmota $kanalmotum)
    {
        $deleteForm = $this->createDeleteForm($kanalmotum);

        return $this->render('kanalmota/show.html.twig', array(
            'kanalmotum' => $kanalmotum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Kanalmota entity.
     *
     * @Route("/{id}/edit", name="kanalmota_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Kanalmota $kanalmotum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($kanalmotum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($kanalmotum);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\KanalmotaType', $kanalmotum);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($kanalmotum);
                $em->flush();

                return $this->redirectToRoute('kanalmota_edit', array('id' => $kanalmotum->getId()));
            }

            return $this->render('kanalmota/edit.html.twig', array(
                'kanalmotum' => $kanalmotum,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Kanalmota entity.
     *
     * @Route("/{id}", name="kanalmota_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Kanalmota $kanalmotum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($kanalmotum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($kanalmotum);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($kanalmotum);
                $em->flush();
            }
            return $this->redirectToRoute('kanalmota_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Kanalmota entity.
     *
     * @param Kanalmota $kanalmotum The Kanalmota entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Kanalmota $kanalmotum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('kanalmota_delete', array('id' => $kanalmotum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
