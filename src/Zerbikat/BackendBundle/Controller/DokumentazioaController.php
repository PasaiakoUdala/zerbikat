<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Dokumentazioa;
use Zerbikat\BackendBundle\Form\DokumentazioaType;

/**
 * Dokumentazioa controller.
 *
 * @Route("/dokumentazioa")
 */
class DokumentazioaController extends Controller
{
    /**
     * Lists all Dokumentazioa entities.
     *
     * @Route("/", name="dokumentazioa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $dokumentazioas = $em->getRepository('BackendBundle:Dokumentazioa')->findAll();
            return $this->render('dokumentazioa/index.html.twig', array(
                'dokumentazioas' => $dokumentazioas,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a new Dokumentazioa entity.
     *
     * @Route("/new", name="dokumentazioa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dokumentazioa = new Dokumentazioa();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\DokumentazioaType', $dokumentazioa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dokumentazioa);
            $em->flush();

            return $this->redirectToRoute('dokumentazioa_show', array('id' => $dokumentazioa->getId()));
        }

        return $this->render('dokumentazioa/new.html.twig', array(
            'dokumentazioa' => $dokumentazioa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Dokumentazioa entity.
     *
     * @Route("/{id}", name="dokumentazioa_show")
     * @Method("GET")
     */
    public function showAction(Dokumentazioa $dokumentazioa)
    {
        $deleteForm = $this->createDeleteForm($dokumentazioa);

        return $this->render('dokumentazioa/show.html.twig', array(
            'dokumentazioa' => $dokumentazioa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Dokumentazioa entity.
     *
     * @Route("/{id}/edit", name="dokumentazioa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dokumentazioa $dokumentazioa)
    {
        $deleteForm = $this->createDeleteForm($dokumentazioa);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\DokumentazioaType', $dokumentazioa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dokumentazioa);
            $em->flush();

            return $this->redirectToRoute('dokumentazioa_edit', array('id' => $dokumentazioa->getId()));
        }

        return $this->render('dokumentazioa/edit.html.twig', array(
            'dokumentazioa' => $dokumentazioa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Dokumentazioa entity.
     *
     * @Route("/{id}", name="dokumentazioa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dokumentazioa $dokumentazioa)
    {
        $form = $this->createDeleteForm($dokumentazioa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dokumentazioa);
            $em->flush();
        }

        return $this->redirectToRoute('dokumentazioa_index');
    }

    /**
     * Creates a form to delete a Dokumentazioa entity.
     *
     * @param Dokumentazioa $dokumentazioa The Dokumentazioa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dokumentazioa $dokumentazioa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dokumentazioa_delete', array('id' => $dokumentazioa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
