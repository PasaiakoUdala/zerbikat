<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Prozedura;
use Zerbikat\BackendBundle\Form\ProzeduraType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Prozedura controller.
 *
 * @Route("/prozedura")
 */
class ProzeduraController extends Controller
{
    /**
     * Lists all Prozedura entities.
     *
     * @Route("/", defaults={"page" = 1}, name="prozedura_index")
     * @Route("/page{page}", name="prozedura_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_KUDEAKETA')) {
            $em = $this->getDoctrine()->getManager();
            $prozeduras = $em->getRepository('BackendBundle:Prozedura')->findAll();

            $adapter = new ArrayAdapter($prozeduras);
            $pagerfanta = new Pagerfanta($adapter);

            $deleteForms = array();
            foreach ($prozeduras as $prozedura) {
                $deleteForms[$prozedura->getId()] = $this->createDeleteForm($prozedura)->createView();
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

            return $this->render('prozedura/index.html.twig', array(
                'prozeduras' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Prozedura entity.
     *
     * @Route("/new", name="prozedura_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $prozedura = new Prozedura();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\ProzeduraType', $prozedura);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($prozedura);
                $em->flush();

//                return $this->redirectToRoute('prozedura_show', array('id' => $prozedura->getId()));
                return $this->redirectToRoute('prozedura_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('prozedura/new.html.twig', array(
                'prozedura' => $prozedura,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Prozedura entity.
     *
     * @Route("/{id}", name="prozedura_show")
     * @Method("GET")
     */
    public function showAction(Prozedura $prozedura)
    {
        $deleteForm = $this->createDeleteForm($prozedura);

        return $this->render('prozedura/show.html.twig', array(
            'prozedura' => $prozedura,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Prozedura entity.
     *
     * @Route("/{id}/edit", name="prozedura_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Prozedura $prozedura)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($prozedura->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($prozedura);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\ProzeduraType', $prozedura);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($prozedura);
                $em->flush();

                return $this->redirectToRoute('prozedura_edit', array('id' => $prozedura->getId()));
            }

            return $this->render('prozedura/edit.html.twig', array(
                'prozedura' => $prozedura,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Prozedura entity.
     *
     * @Route("/{id}", name="prozedura_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Prozedura $prozedura)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($prozedura->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($prozedura);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($prozedura);
                $em->flush();
            }
            return $this->redirectToRoute('prozedura_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Creates a form to delete a Prozedura entity.
     *
     * @param Prozedura $prozedura The Prozedura entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Prozedura $prozedura)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prozedura_delete', array('id' => $prozedura->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
