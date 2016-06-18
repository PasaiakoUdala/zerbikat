<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Tramitea;
use Zerbikat\BackendBundle\Form\TramiteaType;

/**
 * Tramitea controller.
 *
 * @Route("/tramitea")
 */
class TramiteaController extends Controller
{
    /**
     * Lists all Tramitea entities.
     *
     * @Route("/", name="tramitea_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $tramiteas = $em->getRepository('BackendBundle:Tramitea')->findAll();
            return $this->render('tramitea/index.html.twig', array(
                'tramiteas' => $tramiteas,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a new Tramitea entity.
     *
     * @Route("/new", name="tramitea_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tramitea = new Tramitea();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\TramiteaType', $tramitea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramitea);
            $em->flush();

            return $this->redirectToRoute('tramitea_show', array('id' => $tramitea->getId()));
        }

        return $this->render('tramitea/new.html.twig', array(
            'tramitea' => $tramitea,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tramitea entity.
     *
     * @Route("/{id}", name="tramitea_show")
     * @Method("GET")
     */
    public function showAction(Tramitea $tramitea)
    {
        $deleteForm = $this->createDeleteForm($tramitea);

        return $this->render('tramitea/show.html.twig', array(
            'tramitea' => $tramitea,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tramitea entity.
     *
     * @Route("/{id}/edit", name="tramitea_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tramitea $tramitea)
    {
        $deleteForm = $this->createDeleteForm($tramitea);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\TramiteaType', $tramitea);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tramitea);
            $em->flush();

            return $this->redirectToRoute('tramitea_edit', array('id' => $tramitea->getId()));
        }

        return $this->render('tramitea/edit.html.twig', array(
            'tramitea' => $tramitea,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tramitea entity.
     *
     * @Route("/{id}", name="tramitea_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tramitea $tramitea)
    {
        $form = $this->createDeleteForm($tramitea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tramitea);
            $em->flush();
        }

        return $this->redirectToRoute('tramitea_index');
    }

    /**
     * Creates a form to delete a Tramitea entity.
     *
     * @param Tramitea $tramitea The Tramitea entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tramitea $tramitea)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tramitea_delete', array('id' => $tramitea->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
