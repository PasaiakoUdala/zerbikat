<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Azpisaila;
use Zerbikat\BackendBundle\Form\AzpisailaType;

/**
 * Azpisaila controller.
 *
 * @Route("/azpisaila")
 */
class AzpisailaController extends Controller
{
    /**
     * Lists all Azpisaila entities.
     *
     * @Route("/", name="azpisaila_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) 
        {
            $em = $this->getDoctrine()->getManager();
            $azpisailas = $em->getRepository('BackendBundle:Azpisaila')->findAll();
            return $this->render('azpisaila/index.html.twig', array(
                'azpisailas' => $azpisailas,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');            
        }
    }

    /**
     * Creates a new Azpisaila entity.
     *
     * @Route("/new", name="azpisaila_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $azpisaila = new Azpisaila();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\AzpisailaType', $azpisaila);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($azpisaila);
            $em->flush();

            return $this->redirectToRoute('azpisaila_show', array('id' => $azpisaila->getId()));
        }

        return $this->render('azpisaila/new.html.twig', array(
            'azpisaila' => $azpisaila,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Azpisaila entity.
     *
     * @Route("/{id}", name="azpisaila_show")
     * @Method("GET")
     */
    public function showAction(Azpisaila $azpisaila)
    {
        $deleteForm = $this->createDeleteForm($azpisaila);

        return $this->render('azpisaila/show.html.twig', array(
            'azpisaila' => $azpisaila,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Azpisaila entity.
     *
     * @Route("/{id}/edit", name="azpisaila_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Azpisaila $azpisaila)
    {
        $deleteForm = $this->createDeleteForm($azpisaila);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\AzpisailaType', $azpisaila);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($azpisaila);
            $em->flush();

            return $this->redirectToRoute('azpisaila_edit', array('id' => $azpisaila->getId()));
        }

        return $this->render('azpisaila/edit.html.twig', array(
            'azpisaila' => $azpisaila,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Azpisaila entity.
     *
     * @Route("/{id}", name="azpisaila_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Azpisaila $azpisaila)
    {
        $form = $this->createDeleteForm($azpisaila);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($azpisaila);
            $em->flush();
        }

        return $this->redirectToRoute('azpisaila_index');
    }

    /**
     * Creates a form to delete a Azpisaila entity.
     *
     * @param Azpisaila $azpisaila The Azpisaila entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Azpisaila $azpisaila)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('azpisaila_delete', array('id' => $azpisaila->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
