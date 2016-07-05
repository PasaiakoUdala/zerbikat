<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Baldintza;
use Zerbikat\BackendBundle\Form\BaldintzaType;

/**
 * Baldintza controller.
 *
 * @Route("/baldintza")
 */
class BaldintzaController extends Controller
{
    /**
     * Lists all Baldintza entities.
     *
     * @Route("/", name="baldintza_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_KUDEAKETA')) {
            $em = $this->getDoctrine()->getManager();
            $baldintzas = $em->getRepository('BackendBundle:Baldintza')->findAll();

            $deleteForms = array();
            foreach ($baldintzas as $baldintza) {
                $deleteForms[$baldintza->getId()] = $this->createDeleteForm($baldintza)->createView();
            }

            return $this->render('baldintza/index.html.twig', array(
                'baldintzas' => $baldintzas,
                'deleteforms' => $deleteForms
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Baldintza entity.
     *
     * @Route("/new", name="baldintza_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $baldintza = new Baldintza();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\BaldintzaType', $baldintza);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($baldintza);
                $em->flush();

//                return $this->redirectToRoute('baldintza_show', array('id' => $baldintza->getId()));
                return $this->redirectToRoute('baldintza_index');

            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('baldintza/new.html.twig', array(
                'baldintza' => $baldintza,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Baldintza entity.
     *
     * @Route("/{id}", name="baldintza_show")
     * @Method("GET")
     */
    public function showAction(Baldintza $baldintza)
    {
        $deleteForm = $this->createDeleteForm($baldintza);

        return $this->render('baldintza/show.html.twig', array(
            'baldintza' => $baldintza,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Baldintza entity.
     *
     * @Route("/{id}/edit", name="baldintza_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Baldintza $baldintza)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($baldintza->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($baldintza);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\BaldintzaType', $baldintza);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($baldintza);
                $em->flush();

                return $this->redirectToRoute('baldintza_edit', array('id' => $baldintza->getId()));
            }

            return $this->render('baldintza/edit.html.twig', array(
                'baldintza' => $baldintza,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Baldintza entity.
     *
     * @Route("/{id}", name="baldintza_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Baldintza $baldintza)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($baldintza->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($baldintza);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($baldintza);
                $em->flush();
            }
            return $this->redirectToRoute('baldintza_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Baldintza entity.
     *
     * @param Baldintza $baldintza The Baldintza entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Baldintza $baldintza)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('baldintza_delete', array('id' => $baldintza->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
