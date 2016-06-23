<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Espedientekudeaketa;
use Zerbikat\BackendBundle\Form\EspedientekudeaketaType;

/**
 * Espedientekudeaketa controller.
 *
 * @Route("/espedientekudeaketa")
 */
class EspedientekudeaketaController extends Controller
{
    /**
     * Lists all Espedientekudeaketa entities.
     *
     * @Route("/", name="espedientekudeaketa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $espedientekudeaketas = $em->getRepository('BackendBundle:Espedientekudeaketa')->findAll();

            $deleteForms = array();
            foreach ($espedientekudeaketas as $espedientekudeaketa) {
                $deleteForms[$espedientekudeaketa->getId()] = $this->createDeleteForm($espedientekudeaketa)->createView();
            }

            return $this->render('espedientekudeaketa/index.html.twig', array(
                'espedientekudeaketas' => $espedientekudeaketas,
                'deleteforms' => $deleteForms
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Espedientekudeaketa entity.
     *
     * @Route("/new", name="espedientekudeaketa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $espedientekudeaketum = new Espedientekudeaketa();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\EspedientekudeaketaType', $espedientekudeaketum);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($espedientekudeaketum);
                $em->flush();

                return $this->redirectToRoute('espedientekudeaketa_show', array('id' => $espedientekudeaketum->getId()));
            }

            return $this->render('espedientekudeaketa/new.html.twig', array(
                'espedientekudeaketum' => $espedientekudeaketum,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Espedientekudeaketa entity.
     *
     * @Route("/{id}", name="espedientekudeaketa_show")
     * @Method("GET")
     */
    public function showAction(Espedientekudeaketa $espedientekudeaketum)
    {
        $deleteForm = $this->createDeleteForm($espedientekudeaketum);

        return $this->render('espedientekudeaketa/show.html.twig', array(
            'espedientekudeaketum' => $espedientekudeaketum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Espedientekudeaketa entity.
     *
     * @Route("/{id}/edit", name="espedientekudeaketa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Espedientekudeaketa $espedientekudeaketum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $deleteForm = $this->createDeleteForm($espedientekudeaketum);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\EspedientekudeaketaType', $espedientekudeaketum);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($espedientekudeaketum);
                $em->flush();

                return $this->redirectToRoute('espedientekudeaketa_edit', array('id' => $espedientekudeaketum->getId()));
            }

            return $this->render('espedientekudeaketa/edit.html.twig', array(
                'espedientekudeaketum' => $espedientekudeaketum,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Espedientekudeaketa entity.
     *
     * @Route("/{id}", name="espedientekudeaketa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Espedientekudeaketa $espedientekudeaketum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if($auth_checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $form = $this->createDeleteForm($espedientekudeaketum);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($espedientekudeaketum);
                $em->flush();
            }
            return $this->redirectToRoute('espedientekudeaketa_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');            
        }
    }

    /**
     * Creates a form to delete a Espedientekudeaketa entity.
     *
     * @param Espedientekudeaketa $espedientekudeaketum The Espedientekudeaketa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Espedientekudeaketa $espedientekudeaketum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('espedientekudeaketa_delete', array('id' => $espedientekudeaketum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
