<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Zerbitzua;
use Zerbikat\BackendBundle\Form\ZerbitzuaType;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

/**
 * Zerbitzua controller.
 *
 * @Route("/zerbitzua")
 */
class ZerbitzuaController extends Controller
{
    /**
     * Lists all Zerbitzua entities.
     *
     * @Route("/", defaults={"page" = 1}, name="zerbitzua_index")
     * @Route("/page{page}", name="zerbitzua_index_paginated") 
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN')) 
        {
            $em = $this->getDoctrine()->getManager();
            $zerbitzuas = $em->getRepository('BackendBundle:Zerbitzua')->findAll();

            $adapter = new ArrayAdapter($zerbitzuas);
            $pagerfanta = new Pagerfanta($adapter);

            $deleteForms = array();
            foreach ($zerbitzuas as $zerbitzua) {
                $deleteForms[$zerbitzua->getId()] = $this->createDeleteForm($zerbitzua)->createView();
            }

            try {
                $entities = $pagerfanta
                    // Le nombre maximum d'éléments par page
//                    ->setMaxPerPage($this->getUser()->getUdala()->getOrrikatzea())
                    // Notre position actuelle (numéro de page)
                    ->setCurrentPage($page)
                    // On récupère nos entités via Pagerfanta,
                    // celui-ci s'occupe de limiter la requête en fonction de nos réglages.
                    ->getCurrentPageResults()
                ;
            } catch (\Pagerfanta\Exception\NotValidCurrentPageException $e) {
                throw $this->createNotFoundException("Orria ez da existitzen");
            }
            
            return $this->render('zerbitzua/index.html.twig', array(
                'zerbitzuas' => $entities,
                'deleteforms' => $deleteForms,
                'pager' => $pagerfanta,
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Creates a new Zerbitzua entity.
     *
     * @Route("/new", name="zerbitzua_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $zerbitzua = new Zerbitzua();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\ZerbitzuaType', $zerbitzua);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($zerbitzua);
                $em->flush();

//                return $this->redirectToRoute('zerbitzua_show', array('id' => $zerbitzua->getId()));
                return $this->redirectToRoute('zerbitzua_index');
            }
            return $this->render('zerbitzua/new.html.twig', array(
                'zerbitzua' => $zerbitzua,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Zerbitzua entity.
     *
     * @Route("/{id}", name="zerbitzua_show")
     * @Method("GET")
     */
    public function showAction(Zerbitzua $zerbitzua)
    {
        $deleteForm = $this->createDeleteForm($zerbitzua);

        return $this->render('zerbitzua/show.html.twig', array(
            'zerbitzua' => $zerbitzua,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Zerbitzua entity.
     *
     * @Route("/{id}/edit", name="zerbitzua_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Zerbitzua $zerbitzua)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $deleteForm = $this->createDeleteForm($zerbitzua);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\ZerbitzuaType', $zerbitzua);
            $editForm->handleRequest($request);
    
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($zerbitzua);
                $em->flush();
    
                return $this->redirectToRoute('zerbitzua_edit', array('id' => $zerbitzua->getId()));
            }
    
            return $this->render('zerbitzua/edit.html.twig', array(
                'zerbitzua' => $zerbitzua,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Deletes a Zerbitzua entity.
     *
     * @Route("/{id}", name="zerbitzua_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Zerbitzua $zerbitzua)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $form = $this->createDeleteForm($zerbitzua);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($zerbitzua);
                $em->flush();
            }
            return $this->redirectToRoute('zerbitzua_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Zerbitzua entity.
     *
     * @param Zerbitzua $zerbitzua The Zerbitzua entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Zerbitzua $zerbitzua)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zerbitzua_delete', array('id' => $zerbitzua->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
