<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Azpiatala;
use Zerbikat\BackendBundle\Form\AzpiatalaType;

/**
 * Azpiatala controller.
 *
 * @Route("/azpiatala")
 */
class AzpiatalaController extends Controller
{
    /**
     * Lists all Azpiatala entities.
     *
     * @Route("/", name="azpiatala_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            $azpiatalas = $em->getRepository('BackendBundle:Azpiatala')->findAll();

            return $this->render('azpiatala/index.html.twig', array(
                'azpiatalas' => $azpiatalas,
            ));
        }else
        {
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Azpiatala entity.
     *
     * @Route("/new", name="azpiatala_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $azpiatala = new Azpiatala();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\AzpiatalaType', $azpiatala);
            $form->handleRequest($request);

            $form->getData()->setUdala($this->getUser()->getUdala());
            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($azpiatala);
                $em->flush();

                return $this->redirectToRoute('azpiatala_show', array('id' => $azpiatala->getId()));
            }

            return $this->render('azpiatala/new.html.twig', array(
                'azpiatala' => $azpiatala,
                'form' => $form->createView(),
            ));
        }else
        {
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Azpiatala entity.
     *
     * @Route("/{id}", name="azpiatala_show")
     * @Method("GET")
     */
    public function showAction(Azpiatala $azpiatala)
    {
        $deleteForm = $this->createDeleteForm($azpiatala);

        return $this->render('azpiatala/show.html.twig', array(
            'azpiatala' => $azpiatala,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Azpiatala entity.
     *
     * @Route("/{id}/edit", name="azpiatala_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Azpiatala $azpiatala)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($azpiatala->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($azpiatala);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\AzpiatalaType', $azpiatala);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($azpiatala);
                $em->flush();

                return $this->redirectToRoute('azpiatala_edit', array('id' => $azpiatala->getId()));
            }

            return $this->render('azpiatala/edit.html.twig', array(
                'azpiatala' => $azpiatala,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Azpiatala entity.
     *
     * @Route("/{id}", name="azpiatala_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Azpiatala $azpiatala)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($azpiatala->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($azpiatala);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($azpiatala);
                $em->flush();
            }
            return $this->redirectToRoute('azpiatala_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Creates a form to delete a Azpiatala entity.
     *
     * @param Azpiatala $azpiatala The Azpiatala entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Azpiatala $azpiatala)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('azpiatala_delete', array('id' => $azpiatala->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
