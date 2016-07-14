<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Azpiatala;
use Zerbikat\BackendBundle\Form\AzpiatalaType;

use Doctrine\Common\Collections\ArrayCollection;

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
//            $azpiatalas = $em->getRepository('BackendBundle:Azpiatala')->findAll();
            $azpiatalas = $em->getRepository('BackendBundle:Azpiatala')
                ->findBy( array(), array('kodea'=>'ASC') );


            $deleteForms = array();
            foreach ($azpiatalas as $azpiatala) {
                $deleteForms[$azpiatala->getId()] = $this->createDeleteForm($azpiatala)->createView();
            }
            
            return $this->render('azpiatala/index.html.twig', array(
                'azpiatalas' => $azpiatalas,
                'deleteforms' => $deleteForms
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

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            if ($form->isSubmitted() && $form->isValid()) {
//                $azpiatala->setCreatedAt(new \DateTime());
//                $azpiatala->setUpdatedAt(new \DateTime());
                $em = $this->getDoctrine()->getManager();
                $em->persist($azpiatala);
                $em->flush();

                return $this->redirectToRoute('azpiatala_show', array('id' => $azpiatala->getId()));
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
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
            // Create an ArrayCollection of the current Kontzeptuak objects in the database
            $originalKontzeptuak = new ArrayCollection();
            foreach ($azpiatala->getKontzeptuak() as $kontzeptu) {
                $originalKontzeptuak->add($kontzeptu);
            }
            // Create an ArrayCollection of the current Kontzeptuak objects in the database
            $originalParrafoak = new ArrayCollection();
            foreach ($azpiatala->getParrafoak() as $parrafo) {
                $originalParrafoak->add($parrafo);
            }

            $deleteForm = $this->createDeleteForm($azpiatala);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\AzpiatalaType', $azpiatala);
            $editForm->handleRequest($request);

            $em = $this->getDoctrine()->getManager();

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                foreach ($originalKontzeptuak as $kontzeptu)
                {
                    if (false === $azpiatala->getKontzeptuak()->contains($kontzeptu))
                    {
                        $kontzeptu->setAzpiatala(null);
                        $em->remove($kontzeptu);
                        $em->persist($azpiatala);
                    }
                }
                foreach ($originalParrafoak as $parrafo)
                {
                    if (false === $azpiatala->getParrafoak()->contains($parrafo))
                    {
                        $parrafo->setAzpiatala(null);
                        $em->remove($parrafo);

                        $em->persist($azpiatala);
                    }
                }

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
