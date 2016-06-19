<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Saila;
use Zerbikat\BackendBundle\Form\SailaType;

/**
 * Saila controller.
 *
 * @Route("/saila")
 */
class SailaController extends Controller
{
    /**
     * Lists all Saila entities.
     *
     * @Route("/", name="saila_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $sailas = $em->getRepository('BackendBundle:Saila')->findAll();
            return $this->render('saila/index.html.twig', array(
                'sailas' => $sailas,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a new Saila entity.
     *
     * @Route("/new", name="saila_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $saila = new Saila();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\SailaType', $saila);
            $form->handleRequest($request);

            $form->getData()->setUdala($this->getUser()->getUdala());
            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($saila);
                $em->flush();

                return $this->redirectToRoute('saila_show', array('id' => $saila->getId()));
            }

            return $this->render('saila/new.html.twig', array(
                'saila' => $saila,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Finds and displays a Saila entity.
     *
     * @Route("/{id}", name="saila_show")
     * @Method("GET")
     */
    public function showAction(Saila $saila)
    {
        $deleteForm = $this->createDeleteForm($saila);

        return $this->render('saila/show.html.twig', array(
            'saila' => $saila,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Saila entity.
     *
     * @Route("/{id}/edit", name="saila_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Saila $saila)
    {
        $deleteForm = $this->createDeleteForm($saila);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\SailaType', $saila);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($saila);
            $em->flush();

            return $this->redirectToRoute('saila_edit', array('id' => $saila->getId()));
        }

        return $this->render('saila/edit.html.twig', array(
            'saila' => $saila,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Saila entity.
     *
     * @Route("/{id}", name="saila_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Saila $saila)
    {
        $form = $this->createDeleteForm($saila);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($saila);
            $em->flush();
        }

        return $this->redirectToRoute('saila_index');
    }

    /**
     * Creates a form to delete a Saila entity.
     *
     * @param Saila $saila The Saila entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Saila $saila)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('saila_delete', array('id' => $saila->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
