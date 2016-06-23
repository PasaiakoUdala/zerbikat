<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Arrunta;
use Zerbikat\BackendBundle\Form\ArruntaType;

/**
 * Arrunta controller.
 *
 * @Route("/arrunta")
 */
class ArruntaController extends Controller
{
    /**
     * Lists all Arrunta entities.
     *
     * @Route("/", name="arrunta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $arruntas = $em->getRepository('BackendBundle:Arrunta')->findAll();

            $deleteForms = array();
            foreach ($arruntas as $arrunta) {
                $deleteForms[$arrunta->getId()] = $this->createDeleteForm($arrunta)->createView();
            }

            return $this->render('arrunta/index.html.twig', array(
                'arruntas' => $arruntas,
                'deleteforms' => $deleteForms
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');            
        }
    }

    /**
     * Creates a new Arrunta entity.
     *
     * @Route("/new", name="arrunta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $arruntum = new Arrunta();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\ArruntaType', $arruntum);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($arruntum);
                $em->flush();

                return $this->redirectToRoute('arrunta_show', array('id' => $arruntum->getId()));
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('arrunta/new.html.twig', array(
                'arruntum' => $arruntum,
                'form' => $form->createView(),
            ));
        }else
        {
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');            
        }
    }

    /**
     * Finds and displays a Arrunta entity.
     *
     * @Route("/{id}", name="arrunta_show")
     * @Method("GET")
     */
    public function showAction(Arrunta $arruntum)
    {
        $deleteForm = $this->createDeleteForm($arruntum);

        return $this->render('arrunta/show.html.twig', array(
            'arruntum' => $arruntum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Arrunta entity.
     *
     * @Route("/{id}/edit", name="arrunta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Arrunta $arruntum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($arruntum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($arruntum);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\ArruntaType', $arruntum);
            $editForm->handleRequest($request);
    
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($arruntum);
                $em->flush();
    
                return $this->redirectToRoute('arrunta_edit', array('id' => $arruntum->getId()));
            }
    
            return $this->render('arrunta/edit.html.twig', array(
                'arruntum' => $arruntum,
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
     * Deletes a Arrunta entity.
     *
     * @Route("/{id}", name="arrunta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Arrunta $arruntum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($arruntum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($arruntum);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($arruntum);
                $em->flush();
            }
            return $this->redirectToRoute('arrunta_index');
        }else
        {
            //baimenik ez
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');            
        }
    }

    /**
     * Creates a form to delete a Arrunta entity.
     *
     * @param Arrunta $arruntum The Arrunta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Arrunta $arruntum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('arrunta_delete', array('id' => $arruntum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
