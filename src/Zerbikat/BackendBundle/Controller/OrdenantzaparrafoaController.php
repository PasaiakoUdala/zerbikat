<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Ordenantzaparrafoa;
use Zerbikat\BackendBundle\Form\OrdenantzaparrafoaType;

/**
 * Ordenantzaparrafoa controller.
 *
 * @Route("/ordenantzaparrafoa")
 */
class OrdenantzaparrafoaController extends Controller
{
    /**
     * Lists all Ordenantzaparrafoa entities.
     *
     * @Route("/", name="ordenantzaparrafoa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $ordenantzaparrafoas = $em->getRepository('BackendBundle:Ordenantzaparrafoa')->findAll();

            $deleteForms = array();
            foreach ($ordenantzaparrafoas as $ordenantzaparrafoa) {
                $deleteForms[$ordenantzaparrafoa->getId()] = $this->createDeleteForm($ordenantzaparrafoa)->createView();
            }

            return $this->render('ordenantzaparrafoa/index.html.twig', array(
                'ordenantzaparrafoas' => $ordenantzaparrafoas,
                'deleteforms' => $deleteForms
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Ordenantzaparrafoa entity.
     *
     * @Route("/new", name="ordenantzaparrafoa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $ordenantzaparrafoa = new Ordenantzaparrafoa();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\OrdenantzaparrafoaType', $ordenantzaparrafoa);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $ordenantzaparrafoa->setCreatedAt(new \DateTime());
                $ordenantzaparrafoa->setUpdatedAt(new \DateTime());
                $em = $this->getDoctrine()->getManager();
                $em->persist($ordenantzaparrafoa);
                $em->flush();

//                return $this->redirectToRoute('ordenantzaparrafoa_show', array('id' => $ordenantzaparrafoa->getId()));
                return $this->redirectToRoute('ordenantzaparrafoa_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('ordenantzaparrafoa/new.html.twig', array(
                'ordenantzaparrafoa' => $ordenantzaparrafoa,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Ordenantzaparrafoa entity.
     *
     * @Route("/{id}", name="ordenantzaparrafoa_show")
     * @Method("GET")
     */
    public function showAction(Ordenantzaparrafoa $ordenantzaparrafoa)
    {
        $deleteForm = $this->createDeleteForm($ordenantzaparrafoa);

        return $this->render('ordenantzaparrafoa/show.html.twig', array(
            'ordenantzaparrafoa' => $ordenantzaparrafoa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ordenantzaparrafoa entity.
     *
     * @Route("/{id}/edit", name="ordenantzaparrafoa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ordenantzaparrafoa $ordenantzaparrafoa)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($ordenantzaparrafoa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($ordenantzaparrafoa);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\OrdenantzaparrafoaType', $ordenantzaparrafoa);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($ordenantzaparrafoa);
                $em->flush();

                return $this->redirectToRoute('ordenantzaparrafoa_edit', array('id' => $ordenantzaparrafoa->getId()));
            }

            return $this->render('ordenantzaparrafoa/edit.html.twig', array(
                'ordenantzaparrafoa' => $ordenantzaparrafoa,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Ordenantzaparrafoa entity.
     *
     * @Route("/{id}", name="ordenantzaparrafoa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ordenantzaparrafoa $ordenantzaparrafoa)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($ordenantzaparrafoa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($ordenantzaparrafoa);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($ordenantzaparrafoa);
                $em->flush();
            }
            return $this->redirectToRoute('ordenantzaparrafoa_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Creates a form to delete a Ordenantzaparrafoa entity.
     *
     * @param Ordenantzaparrafoa $ordenantzaparrafoa The Ordenantzaparrafoa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ordenantzaparrafoa $ordenantzaparrafoa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ordenantzaparrafoa_delete', array('id' => $ordenantzaparrafoa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
