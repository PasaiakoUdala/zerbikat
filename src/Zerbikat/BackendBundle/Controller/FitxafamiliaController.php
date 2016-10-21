<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Fitxafamilia;
use Zerbikat\BackendBundle\Form\FitxafamiliaType;

/**
 * Fitxafamilia controller.
 *
 * @Route("/fitxafamilia")
 */
class FitxafamiliaController extends Controller
{
    /**
     * Lists all Fitxafamilia entities.
     *
     * @Route("/", name="fitxafamilia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fitxafamilias = $em->getRepository('BackendBundle:Fitxafamilia')->findAll();

        return $this->render('fitxafamilia/index.html.twig', array(
            'fitxafamilias' => $fitxafamilias,
        ));
    }

    /**
     * Creates a new Fitxafamilia entity.
     *
     * @Route("/newfromfitxa", name="fitxafamilia_newfromfitxa")
     * @Method({"GET", "POST"})
     */
    public function newfromfitxaAction(Request $request)
    {
        $fitxafamilium = new Fitxafamilia();
        $fitxafamilium->setUdala( $this->getUser()->getUdala() );
        $form = $this->createForm('Zerbikat\BackendBundle\Form\FitxafamiliaType', $fitxafamilium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($fitxafamilium);
            $em->flush();

            return $this->redirectToRoute('fitxa_edit', array('id' => $fitxafamilium->getFitxa()->getId()));
        }

        return $this->render('fitxafamilia/new.html.twig', array(
            'fitxafamilium' => $fitxafamilium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Fitxafamilia entity.
     *
     * @Route("/new", name="fitxafamilia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fitxafamilium = new Fitxafamilia();
        $fitxafamilium->setUdala( $this->getUser()->getUdala() );
        $form = $this->createForm('Zerbikat\BackendBundle\Form\FitxafamiliaType', $fitxafamilium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fitxafamilium);
            $em->flush();

            return $this->redirectToRoute('fitxafamilia_show', array('id' => $fitxafamilium->getId()));
        }

        return $this->render('fitxafamilia/new.html.twig', array(
            'fitxafamilium' => $fitxafamilium,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a Fitxafamilia entity.
     *
     * @Route("/{id}", name="fitxafamilia_show")
     * @Method("GET")
     */
    public function showAction(Fitxafamilia $fitxafamilium)
    {
        $deleteForm = $this->createDeleteForm($fitxafamilium);

        return $this->render('fitxafamilia/show.html.twig', array(
            'fitxafamilium' => $fitxafamilium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fitxafamilia entity.
     *
     * @Route("/{id}/edit", name="fitxafamilia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fitxafamilia $fitxafamilium)
    {
        $deleteForm = $this->createDeleteForm($fitxafamilium);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\FitxafamiliaType', $fitxafamilium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fitxafamilium);
            $em->flush();

            return $this->redirectToRoute('fitxafamilia_edit', array('id' => $fitxafamilium->getId()));
        }

        return $this->render('fitxafamilia/edit.html.twig', array(
            'fitxafamilium' => $fitxafamilium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Fitxafamilia entity.
     *
     * @Route("/{id}", name="fitxafamilia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fitxafamilia $fitxafamilium)
    {
        $form = $this->createDeleteForm($fitxafamilium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fitxafamilium);
            $em->flush();
        }

        return $this->redirectToRoute('fitxafamilia_index');
    }

    /**
     * Creates a form to delete a Fitxafamilia entity.
     *
     * @param Fitxafamilia $fitxafamilium The Fitxafamilia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fitxafamilia $fitxafamilium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fitxafamilia_delete', array('id' => $fitxafamilium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
