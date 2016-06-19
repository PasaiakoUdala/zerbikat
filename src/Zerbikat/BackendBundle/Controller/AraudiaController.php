<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Araudia;
use Zerbikat\BackendBundle\Form\AraudiaType;

/**
 * Araudia controller.
 *
 * @Route("/araudia")
 */
class AraudiaController extends Controller
{
    /**
     * Lists all Araudia entities.
     *
     * @Route("/", name="araudia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $em = $this->getDoctrine()->getManager();

            $araudias = $em->getRepository('BackendBundle:Araudia')->findAll();

            return $this->render('araudia/index.html.twig', array(
                'araudias' => $araudias,
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }


    /**
     * Creates a new Araudia entity.
     *
     * @Route("/new", name="araudia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $araudium = new Araudia();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\AraudiaType', $araudium);
            $form->handleRequest($request);

            $form->getData()->setUdala($this->getUser()->getUdala());
            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($araudium);
                $em->flush();

                return $this->redirectToRoute('araudia_show', array('id' => $araudium->getId()));
            }

            return $this->render('araudia/new.html.twig', array(
                'araudium' => $araudium,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Finds and displays a Araudia entity.
     *
     * @Route("/{id}", name="araudia_show")
     * @Method("GET")
     */
    public function showAction(Araudia $araudium)
    {
        $deleteForm = $this->createDeleteForm($araudium);

        return $this->render('araudia/show.html.twig', array(
            'araudium' => $araudium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Araudia entity.
     *
     * @Route("/{id}/edit", name="araudia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Araudia $araudium)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($araudium->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($araudium);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\AraudiaType', $araudium);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($araudium);
                $em->flush();

                return $this->redirectToRoute('araudia_edit', array('id' => $araudium->getId()));
            }

            return $this->render('araudia/edit.html.twig', array(
                'araudium' => $araudium,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Deletes a Araudia entity.
     *
     * @Route("/{id}", name="araudia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Araudia $araudium)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($araudium->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($araudium);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($araudium);
                $em->flush();
            }
            return $this->redirectToRoute('araudia_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('fitxa_index');
        }
    }

    /**
     * Creates a form to delete a Araudia entity.
     *
     * @param Araudia $araudium The Araudia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Araudia $araudium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('araudia_delete', array('id' => $araudium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
