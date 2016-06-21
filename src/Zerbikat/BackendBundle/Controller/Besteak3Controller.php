<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Besteak3;
use Zerbikat\BackendBundle\Form\Besteak3Type;

/**
 * Besteak3 controller.
 *
 * @Route("/besteak3")
 */
class Besteak3Controller extends Controller
{
    /**
     * Lists all Besteak3 entities.
     *
     * @Route("/", name="besteak3_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $besteak3s = $em->getRepository('BackendBundle:Besteak3')->findAll();
            return $this->render('besteak3/index.html.twig', array(
                'besteak3s' => $besteak3s,
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Besteak3 entity.
     *
     * @Route("/new", name="besteak3_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $besteak3 = new Besteak3();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\Besteak3Type', $besteak3);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($besteak3);
                $em->flush();

                return $this->redirectToRoute('besteak3_show', array('id' => $besteak3->getId()));
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('besteak3/new.html.twig', array(
                'besteak3' => $besteak3,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Besteak3 entity.
     *
     * @Route("/{id}", name="besteak3_show")
     * @Method("GET")
     */
    public function showAction(Besteak3 $besteak3)
    {
        $deleteForm = $this->createDeleteForm($besteak3);

        return $this->render('besteak3/show.html.twig', array(
            'besteak3' => $besteak3,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Besteak3 entity.
     *
     * @Route("/{id}/edit", name="besteak3_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Besteak3 $besteak3)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($besteak3->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($besteak3);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\Besteak3Type', $besteak3);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($besteak3);
                $em->flush();

                return $this->redirectToRoute('besteak3_edit', array('id' => $besteak3->getId()));
            }

            return $this->render('besteak3/edit.html.twig', array(
                'besteak3' => $besteak3,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Besteak3 entity.
     *
     * @Route("/{id}", name="besteak3_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Besteak3 $besteak3)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($besteak3->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($besteak3);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($besteak3);
                $em->flush();
            }
            return $this->redirectToRoute('besteak3_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Besteak3 entity.
     *
     * @param Besteak3 $besteak3 The Besteak3 entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Besteak3 $besteak3)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('besteak3_delete', array('id' => $besteak3->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
