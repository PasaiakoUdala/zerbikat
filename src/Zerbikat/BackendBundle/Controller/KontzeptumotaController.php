<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Kontzeptumota;
use Zerbikat\BackendBundle\Form\KontzeptumotaType;

/**
 * Kontzeptumota controller.
 *
 * @Route("/kontzeptumota")
 */
class KontzeptumotaController extends Controller
{
    /**
     * Lists all Kontzeptumota entities.
     *
     * @Route("/", name="kontzeptumota_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_KUDEAKETA'))
        {
            $em = $this->getDoctrine()->getManager();
            $kontzeptumotas = $em->getRepository('BackendBundle:Kontzeptumota')->findAll();

            $deleteForms = array();
            foreach ($kontzeptumotas as $kontzeptua) {
                $deleteForms[$kontzeptua->getId()] = $this->createDeleteForm($kontzeptua)->createView();
            }

            return $this->render('kontzeptumota/index.html.twig', array(
                'kontzeptumotas' => $kontzeptumotas,
                'deleteforms' => $deleteForms
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a new Kontzeptumota entity.
     *
     * @Route("/new", name="kontzeptumota_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_ADMIN'))
        {
            $kontzeptumotum = new Kontzeptumota();
            $form = $this->createForm('Zerbikat\BackendBundle\Form\KontzeptumotaType', $kontzeptumotum);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($kontzeptumotum);
                $em->flush();

//                return $this->redirectToRoute('kontzeptumota_show', array('id' => $kontzeptumotum->getId()));
                return $this->redirectToRoute('kontzeptumota_index');
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

            return $this->render('kontzeptumota/new.html.twig', array(
                'kontzeptumotum' => $kontzeptumotum,
                'form' => $form->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Finds and displays a Kontzeptumota entity.
     *
     * @Route("/{id}", name="kontzeptumota_show")
     * @Method("GET")
     */
    public function showAction(Kontzeptumota $kontzeptumotum)
    {
        $deleteForm = $this->createDeleteForm($kontzeptumotum);

        return $this->render('kontzeptumota/show.html.twig', array(
            'kontzeptumotum' => $kontzeptumotum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Kontzeptumota entity.
     *
     * @Route("/{id}/edit", name="kontzeptumota_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Kontzeptumota $kontzeptumotum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($kontzeptumotum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($kontzeptumotum);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\KontzeptumotaType', $kontzeptumotum);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($kontzeptumotum);
                $em->flush();

                return $this->redirectToRoute('kontzeptumota_edit', array('id' => $kontzeptumotum->getId()));
            }

            return $this->render('kontzeptumota/edit.html.twig', array(
                'kontzeptumotum' => $kontzeptumotum,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Kontzeptumota entity.
     *
     * @Route("/{id}", name="kontzeptumota_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Kontzeptumota $kontzeptumotum)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($kontzeptumotum->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($kontzeptumotum);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($kontzeptumotum);
                $em->flush();
            }
            return $this->redirectToRoute('kontzeptumota_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Kontzeptumota entity.
     *
     * @param Kontzeptumota $kontzeptumotum The Kontzeptumota entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Kontzeptumota $kontzeptumotum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('kontzeptumota_delete', array('id' => $kontzeptumotum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
