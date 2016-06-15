<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Prozedura;
use Zerbikat\BackendBundle\Form\ProzeduraType;

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
     * @Route("/", name="prozedura_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prozeduras = $em->getRepository('BackendBundle:Prozedura')->findAll();

        return $this->render('prozedura/index.html.twig', array(
            'prozeduras' => $prozeduras,
        ));
    }

    /**
     * Creates a new Prozedura entity.
     *
     * @Route("/new", name="prozedura_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $prozedura = new Prozedura();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\ProzeduraType', $prozedura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prozedura);
            $em->flush();

            return $this->redirectToRoute('prozedura_show', array('id' => $prozedura->getId()));
        }

        return $this->render('prozedura/new.html.twig', array(
            'prozedura' => $prozedura,
            'form' => $form->createView(),
        ));
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
    }

    /**
     * Deletes a Prozedura entity.
     *
     * @Route("/{id}", name="prozedura_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Prozedura $prozedura)
    {
        $form = $this->createDeleteForm($prozedura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($prozedura);
            $em->flush();
        }

        return $this->redirectToRoute('prozedura_index');
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
