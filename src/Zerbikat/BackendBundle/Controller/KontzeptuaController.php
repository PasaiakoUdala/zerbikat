<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Kontzeptua;
use Zerbikat\BackendBundle\Form\KontzeptuaType;

/**
 * Kontzeptua controller.
 *
 * @Route("/kontzeptua")
 */
class KontzeptuaController extends Controller
{
    /**
     * Lists all Kontzeptua entities.
     *
     * @Route("/", name="kontzeptua_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $kontzeptuas = $em->getRepository('BackendBundle:Kontzeptua')->findAll();
            return $this->render('kontzeptua/index.html.twig', array(
                'kontzeptuas' => $kontzeptuas,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a new Kontzeptua entity.
     *
     * @Route("/new", name="kontzeptua_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $kontzeptua = new Kontzeptua();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\KontzeptuaType', $kontzeptua);
            $form->handleRequest($request);

            $form->getData()->setUdala($this->getUser()->getUdala());
            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($kontzeptua);
                $em->flush();

                return $this->redirectToRoute('kontzeptua_show', array('id' => $kontzeptua->getId()));
            }

            return $this->render('kontzeptua/new.html.twig', array(
                'kontzeptua' => $kontzeptua,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Finds and displays a Kontzeptua entity.
     *
     * @Route("/{id}", name="kontzeptua_show")
     * @Method("GET")
     */
    public function showAction(Kontzeptua $kontzeptua)
    {
        $deleteForm = $this->createDeleteForm($kontzeptua);

        return $this->render('kontzeptua/show.html.twig', array(
            'kontzeptua' => $kontzeptua,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Kontzeptua entity.
     *
     * @Route("/{id}/edit", name="kontzeptua_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Kontzeptua $kontzeptua)
    {
        $deleteForm = $this->createDeleteForm($kontzeptua);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\KontzeptuaType', $kontzeptua);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($kontzeptua);
            $em->flush();

            return $this->redirectToRoute('kontzeptua_edit', array('id' => $kontzeptua->getId()));
        }

        return $this->render('kontzeptua/edit.html.twig', array(
            'kontzeptua' => $kontzeptua,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Kontzeptua entity.
     *
     * @Route("/{id}", name="kontzeptua_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Kontzeptua $kontzeptua)
    {
        $form = $this->createDeleteForm($kontzeptua);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($kontzeptua);
            $em->flush();
        }

        return $this->redirectToRoute('kontzeptua_index');
    }

    /**
     * Creates a form to delete a Kontzeptua entity.
     *
     * @param Kontzeptua $kontzeptua The Kontzeptua entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Kontzeptua $kontzeptua)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('kontzeptua_delete', array('id' => $kontzeptua->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
