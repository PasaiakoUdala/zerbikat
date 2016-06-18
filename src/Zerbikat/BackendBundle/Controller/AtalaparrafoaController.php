<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Atalaparrafoa;
use Zerbikat\BackendBundle\Form\AtalaparrafoaType;

/**
 * Atalaparrafoa controller.
 *
 * @Route("/atalaparrafoa")
 */
class AtalaparrafoaController extends Controller
{
    /**
     * Lists all Atalaparrafoa entities.
     *
     * @Route("/", name="atalaparrafoa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            $atalaparrafoas = $em->getRepository('BackendBundle:Atalaparrafoa')->findAll();

            return $this->render('atalaparrafoa/index.html.twig', array(
                'atalaparrafoas' => $atalaparrafoas,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a new Atalaparrafoa entity.
     *
     * @Route("/new", name="atalaparrafoa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $atalaparrafoa = new Atalaparrafoa();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\AtalaparrafoaType', $atalaparrafoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atalaparrafoa);
            $em->flush();

            return $this->redirectToRoute('atalaparrafoa_show', array('id' => $atalaparrafoa->getId()));
        }

        return $this->render('atalaparrafoa/new.html.twig', array(
            'atalaparrafoa' => $atalaparrafoa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Atalaparrafoa entity.
     *
     * @Route("/{id}", name="atalaparrafoa_show")
     * @Method("GET")
     */
    public function showAction(Atalaparrafoa $atalaparrafoa)
    {
        $deleteForm = $this->createDeleteForm($atalaparrafoa);

        return $this->render('atalaparrafoa/show.html.twig', array(
            'atalaparrafoa' => $atalaparrafoa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Atalaparrafoa entity.
     *
     * @Route("/{id}/edit", name="atalaparrafoa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Atalaparrafoa $atalaparrafoa)
    {
        $deleteForm = $this->createDeleteForm($atalaparrafoa);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\AtalaparrafoaType', $atalaparrafoa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atalaparrafoa);
            $em->flush();

            return $this->redirectToRoute('atalaparrafoa_edit', array('id' => $atalaparrafoa->getId()));
        }

        return $this->render('atalaparrafoa/edit.html.twig', array(
            'atalaparrafoa' => $atalaparrafoa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Atalaparrafoa entity.
     *
     * @Route("/{id}", name="atalaparrafoa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Atalaparrafoa $atalaparrafoa)
    {
        $form = $this->createDeleteForm($atalaparrafoa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($atalaparrafoa);
            $em->flush();
        }

        return $this->redirectToRoute('atalaparrafoa_index');
    }

    /**
     * Creates a form to delete a Atalaparrafoa entity.
     *
     * @param Atalaparrafoa $atalaparrafoa The Atalaparrafoa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Atalaparrafoa $atalaparrafoa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('atalaparrafoa_delete', array('id' => $atalaparrafoa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
