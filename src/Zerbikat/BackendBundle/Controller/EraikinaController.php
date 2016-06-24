<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Eraikina;
use Zerbikat\BackendBundle\Form\EraikinaType;

/**
 * Eraikina controller.
 *
 * @Route("/eraikina")
 */
class EraikinaController extends Controller
{
    /**
     * Lists all Eraikina entities.
     *
     * @Route("/", name="eraikina_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $eraikinas = $em->getRepository('BackendBundle:Eraikina')->findAll();

            $deleteForms = array();
            foreach ($eraikinas as $eraikina) {
                $deleteForms[$eraikina->getId()] = $this->createDeleteForm($eraikina)->createView();
            }

            return $this->render('eraikina/index.html.twig', array(
                'eraikinas' => $eraikinas,
                'deleteforms' => $deleteForms
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Eraikina entity.
     *
     * @Route("/new", name="eraikina_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $eraikina = new Eraikina();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\EraikinaType', $eraikina);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($eraikina);
                $em->flush();

//                return $this->redirectToRoute('eraikina_show', array('id' => $eraikina->getId()));
                return $this->redirectToRoute('eraikina_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('eraikina/new.html.twig', array(
                'eraikina' => $eraikina,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Eraikina entity.
     *
     * @Route("/{id}", name="eraikina_show")
     * @Method("GET")
     */
    public function showAction(Eraikina $eraikina)
    {
        $deleteForm = $this->createDeleteForm($eraikina);

        return $this->render('eraikina/show.html.twig', array(
            'eraikina' => $eraikina,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Eraikina entity.
     *
     * @Route("/{id}/edit", name="eraikina_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Eraikina $eraikina)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($eraikina->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($eraikina);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\EraikinaType', $eraikina);
            $editForm->handleRequest($request);
    
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($eraikina);
                $em->flush();
    
                return $this->redirectToRoute('eraikina_edit', array('id' => $eraikina->getId()));
            }
    
            return $this->render('eraikina/edit.html.twig', array(
                'eraikina' => $eraikina,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }            
    }

    /**
     * Deletes a Eraikina entity.
     *
     * @Route("/{id}", name="eraikina_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Eraikina $eraikina)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($eraikina->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($eraikina);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($eraikina);
                $em->flush();
            }
            return $this->redirectToRoute('eraikina_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Eraikina entity.
     *
     * @param Eraikina $eraikina The Eraikina entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Eraikina $eraikina)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eraikina_delete', array('id' => $eraikina->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
