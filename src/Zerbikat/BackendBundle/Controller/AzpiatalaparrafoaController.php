<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Azpiatalaparrafoa;
use Zerbikat\BackendBundle\Form\AzpiatalaparrafoaType;

/**
 * Azpiatalaparrafoa controller.
 *
 * @Route("/azpiatalaparrafoa")
 */
class AzpiatalaparrafoaController extends Controller
{
    /**
     * Lists all Azpiatalaparrafoa entities.
     *
     * @Route("/", name="azpiatalaparrafoa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $azpiatalaparrafoas = $em->getRepository('BackendBundle:Azpiatalaparrafoa')->findAll();

        return $this->render('azpiatalaparrafoa/index.html.twig', array(
            'azpiatalaparrafoas' => $azpiatalaparrafoas,
        ));
    }

    /**
     * Creates a new Azpiatalaparrafoa entity.
     *
     * @Route("/new", name="azpiatalaparrafoa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) 
        {
            $azpiatalaparrafoa = new Azpiatalaparrafoa();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\AzpiatalaparrafoaType', $azpiatalaparrafoa);
            $form->handleRequest($request);
    
            $form->getData()->setUdala($this->getUser()->getUdala());
            $form->setData($form->getData());
            
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($azpiatalaparrafoa);
                $em->flush();
    
                return $this->redirectToRoute('azpiatalaparrafoa_show', array('id' => $azpiatalaparrafoa->getId()));
            }
    
            return $this->render('azpiatalaparrafoa/new.html.twig', array(
                'azpiatalaparrafoa' => $azpiatalaparrafoa,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Finds and displays a Azpiatalaparrafoa entity.
     *
     * @Route("/{id}", name="azpiatalaparrafoa_show")
     * @Method("GET")
     */
    public function showAction(Azpiatalaparrafoa $azpiatalaparrafoa)
    {
        $deleteForm = $this->createDeleteForm($azpiatalaparrafoa);

        return $this->render('azpiatalaparrafoa/show.html.twig', array(
            'azpiatalaparrafoa' => $azpiatalaparrafoa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Azpiatalaparrafoa entity.
     *
     * @Route("/{id}/edit", name="azpiatalaparrafoa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Azpiatalaparrafoa $azpiatalaparrafoa)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($azpiatalaparrafoa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($azpiatalaparrafoa);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\AzpiatalaparrafoaType', $azpiatalaparrafoa);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($azpiatalaparrafoa);
                $em->flush();

                return $this->redirectToRoute('azpiatalaparrafoa_edit', array('id' => $azpiatalaparrafoa->getId()));
            }

            return $this->render('azpiatalaparrafoa/edit.html.twig', array(
                'azpiatalaparrafoa' => $azpiatalaparrafoa,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Azpiatalaparrafoa entity.
     *
     * @Route("/{id}", name="azpiatalaparrafoa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Azpiatalaparrafoa $azpiatalaparrafoa)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($azpiatalaparrafoa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($azpiatalaparrafoa);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($azpiatalaparrafoa);
                $em->flush();
            }
            return $this->redirectToRoute('azpiatalaparrafoa_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Azpiatalaparrafoa entity.
     *
     * @param Azpiatalaparrafoa $azpiatalaparrafoa The Azpiatalaparrafoa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Azpiatalaparrafoa $azpiatalaparrafoa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('azpiatalaparrafoa_delete', array('id' => $azpiatalaparrafoa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
