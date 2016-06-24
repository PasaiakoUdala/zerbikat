<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Eremuak;
use Zerbikat\BackendBundle\Form\EremuakType;

/**
 * Eremuak controller.
 *
 * @Route("/eremuak")
 */
class EremuakController extends Controller
{
    /**
     * Lists all Eremuak entities.
     *
     * @Route("/", name="eremuak_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $em = $this->getDoctrine()->getManager();
            $eremuaks = $em->getRepository('BackendBundle:Eremuak')->findAll();

            $deleteForms = array();
            foreach ($eremuaks as $eremuak) {
                $deleteForms[$eremuak->getId()] = $this->createDeleteForm($eremuak)->createView();
            }

            return $this->render('eremuak/index.html.twig', array(
                'eremuaks' => $eremuaks,
                'deleteforms' => $deleteForms
            ));
        }else if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('eremuak_edit', array('id' => $this->getUser()->getUdala()->getEremuak()->getId()));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Eremuak entity.
     *
     * @Route("/new", name="eremuak_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $eremuak = new Eremuak();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\EremuakType', $eremuak);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($eremuak);
                $em->flush();

//                return $this->redirectToRoute('eremuak_show', array('id' => $eremuak->getId()));
                return $this->redirectToRoute('eremuak_index');
            }

            return $this->render('eremuak/new.html.twig', array(
                'eremuak' => $eremuak,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Eremuak entity.
     *
     * @Route("/{id}", name="eremuak_show")
     * @Method("GET")
     */
    public function showAction(Eremuak $eremuak)
    {
        $deleteForm = $this->createDeleteForm($eremuak);

        return $this->render('eremuak/show.html.twig', array(
            'eremuak' => $eremuak,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Eremuak entity.
     *
     * @Route("/{id}/edit", name="eremuak_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Eremuak $eremuak)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($eremuak->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($eremuak);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\EremuakType', $eremuak);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($eremuak);
                $em->flush();

                return $this->redirectToRoute('eremuak_edit', array('id' => $eremuak->getId()));
            }

            return $this->render('eremuak/edit.html.twig', array(
                'eremuak' => $eremuak,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Eremuak entity.
     *
     * @Route("/{id}", name="eremuak_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Eremuak $eremuak)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $form = $this->createDeleteForm($eremuak);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($eremuak);
                $em->flush();
            }
            return $this->redirectToRoute('eremuak_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Eremuak entity.
     *
     * @param Eremuak $eremuak The Eremuak entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Eremuak $eremuak)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eremuak_delete', array('id' => $eremuak->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
