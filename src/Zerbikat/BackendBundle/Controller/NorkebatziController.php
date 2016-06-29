<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Norkebatzi;
use Zerbikat\BackendBundle\Form\NorkebatziType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Norkebatzi controller.
 *
 * @Route("/norkebatzi")
 */
class NorkebatziController extends Controller
{
    /**
     * Lists all Norkebatzi entities.
     *
     * @Route("/", defaults={"page" = 1}, name="norkebatzi_index")
     * @Route("/page{page}", name="norkebatzi_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $norkebatzis = $em->getRepository('BackendBundle:Norkebatzi')->findAll();

            $adapter = new ArrayAdapter($norkebatzis);
            $pagerfanta = new Pagerfanta($adapter);

            $deleteForms = array();
            foreach ($norkebatzis as $norkebatzi) {
                $deleteForms[$norkebatzi->getId()] = $this->createDeleteForm($norkebatzi)->createView();
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

            return $this->render('norkebatzi/index.html.twig', array(
                'norkebatzis' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Norkebatzi entity.
     *
     * @Route("/new", name="norkebatzi_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $norkebatzi = new Norkebatzi();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\NorkebatziType', $norkebatzi);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($norkebatzi);
                $em->flush();

//                return $this->redirectToRoute('norkebatzi_show', array('id' => $norkebatzi->getId()));
                return $this->redirectToRoute('norkebatzi_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('norkebatzi/new.html.twig', array(
                'norkebatzi' => $norkebatzi,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Norkebatzi entity.
     *
     * @Route("/{id}", name="norkebatzi_show")
     * @Method("GET")
     */
    public function showAction(Norkebatzi $norkebatzi)
    {
        $deleteForm = $this->createDeleteForm($norkebatzi);

        return $this->render('norkebatzi/show.html.twig', array(
            'norkebatzi' => $norkebatzi,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Norkebatzi entity.
     *
     * @Route("/{id}/edit", name="norkebatzi_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Norkebatzi $norkebatzi)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($norkebatzi->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($norkebatzi);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\NorkebatziType', $norkebatzi);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($norkebatzi);
                $em->flush();

                return $this->redirectToRoute('norkebatzi_edit', array('id' => $norkebatzi->getId()));
            }

            return $this->render('norkebatzi/edit.html.twig', array(
                'norkebatzi' => $norkebatzi,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Norkebatzi entity.
     *
     * @Route("/{id}", name="norkebatzi_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Norkebatzi $norkebatzi)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($norkebatzi->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($norkebatzi);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($norkebatzi);
                $em->flush();
            }
            return $this->redirectToRoute('norkebatzi_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Creates a form to delete a Norkebatzi entity.
     *
     * @param Norkebatzi $norkebatzi The Norkebatzi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Norkebatzi $norkebatzi)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('norkebatzi_delete', array('id' => $norkebatzi->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
