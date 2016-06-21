<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Besteak2;
use Zerbikat\BackendBundle\Form\Besteak2Type;

/**
 * Besteak2 controller.
 *
 * @Route("/besteak2")
 */
class Besteak2Controller extends Controller
{
    /**
     * Lists all Besteak2 entities.
     *
     * @Route("/", name="besteak2_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $besteak2s = $em->getRepository('BackendBundle:Besteak2')->findAll();
            return $this->render('besteak2/index.html.twig', array(
                'besteak2s' => $besteak2s,
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Besteak2 entity.
     *
     * @Route("/new", name="besteak2_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $besteak2 = new Besteak2();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\Besteak2Type', $besteak2);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($besteak2);
                $em->flush();

                return $this->redirectToRoute('besteak2_show', array('id' => $besteak2->getId()));
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('besteak2/new.html.twig', array(
                'besteak2' => $besteak2,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Besteak2 entity.
     *
     * @Route("/{id}", name="besteak2_show")
     * @Method("GET")
     */
    public function showAction(Besteak2 $besteak2)
    {
        $deleteForm = $this->createDeleteForm($besteak2);

        return $this->render('besteak2/show.html.twig', array(
            'besteak2' => $besteak2,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Besteak2 entity.
     *
     * @Route("/{id}/edit", name="besteak2_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Besteak2 $besteak2)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($besteak2->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($besteak2);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\Besteak2Type', $besteak2);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($besteak2);
                $em->flush();

                return $this->redirectToRoute('besteak2_edit', array('id' => $besteak2->getId()));
            }

            return $this->render('besteak2/edit.html.twig', array(
                'besteak2' => $besteak2,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Besteak2 entity.
     *
     * @Route("/{id}", name="besteak2_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Besteak2 $besteak2)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($besteak2->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($besteak2);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($besteak2);
                $em->flush();
            }
            return $this->redirectToRoute('besteak2_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Creates a form to delete a Besteak2 entity.
     *
     * @param Besteak2 $besteak2 The Besteak2 entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Besteak2 $besteak2)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('besteak2_delete', array('id' => $besteak2->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
