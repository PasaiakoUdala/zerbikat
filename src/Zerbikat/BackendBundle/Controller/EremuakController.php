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
            return $this->render('eremuak/index.html.twig', array(
                'eremuaks' => $eremuaks,
            ));
        }else if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('eremuak_edit', array('id' => $this->getUser()->getUdala()->getEremuak()->getId()));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
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

                return $this->redirectToRoute('eremuak_show', array('id' => $eremuak->getId()));
            }

            return $this->render('eremuak/new.html.twig', array(
                'eremuak' => $eremuak,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
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
    }

    /**
     * Deletes a Eremuak entity.
     *
     * @Route("/{id}", name="eremuak_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Eremuak $eremuak)
    {
        $form = $this->createDeleteForm($eremuak);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eremuak);
            $em->flush();
        }

        return $this->redirectToRoute('eremuak_index');
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
