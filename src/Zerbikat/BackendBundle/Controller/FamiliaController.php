<?php

    namespace Zerbikat\BackendBundle\Controller;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Zerbikat\BackendBundle\Entity\Familia;
    use Zerbikat\BackendBundle\Form\FamiliaType;
    use Pagerfanta\Adapter\DoctrineORMAdapter;
    use Pagerfanta\Pagerfanta;
    use Pagerfanta\Adapter\ArrayAdapter;

    /**
     * Familia controller.
     *
     * @Route("/familia")
     */
    class FamiliaController extends Controller
    {

        /**
         * Lists all Familia entities.
         *
         * @Route("/", defaults={"page" = 1}, name="familia_index")
         * @Route("/page{page}", name="familia_index_paginated")
         * @Method("GET")
         */
        public function indexAction ( $page )
        {
            $auth_checker = $this->get( 'security.authorization_checker' );
            if ( $auth_checker->isGranted( 'ROLE_KUDEAKETA' ) ) {
                $em = $this->getDoctrine()->getManager();
                $familias = $em->getRepository( 'BackendBundle:Familia' )->findBy(
                    array ('parent' => null),
                    array ('ordena' => 'ASC')
                );
                $deleteForms = array ();
                foreach ( $familias as $familia ) {
                    $deleteForms[$familia->getId()] = $this->createDeleteForm( $familia )->createView();
                }

                return $this->render(
                    'familia/index.html.twig',
                    array (
                        'familias'    => $familias,
                        'deleteforms' => $deleteForms,
                    )
                );
            } else {
                return $this->redirectToRoute( 'backend_errorea' );
            }
        }

        /**
         * Creates a new Familia entity.
         *
         * @Route("/new", name="familia_new")
         * @Method({"GET", "POST"})
         */
        public function newAction ( Request $request )
        {
            $auth_checker = $this->get( 'security.authorization_checker' );
            if ( $auth_checker->isGranted( 'ROLE_ADMIN' ) ) {
                $familium = new Familia();
                $form = $this->createForm( 'Zerbikat\BackendBundle\Form\FamiliaType', $familium );
                $form->handleRequest( $request );

                if ( $form->isSubmitted() && $form->isValid() ) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist( $familium );
                    $em->flush();

                    return $this->redirectToRoute( 'familia_index' );
                } else {
                    $form->getData()->setUdala( $this->getUser()->getUdala() );
                    $form->setData( $form->getData() );
                }

                return $this->render(
                    'familia/new.html.twig',
                    array (
                        'familium' => $familium,
                        'form'     => $form->createView(),
                    )
                );
            } else {
                return $this->redirectToRoute( 'backend_errorea' );
            }
        }

        /**
         * Finds and displays a Familia entity.
         *
         * @Route("/{id}", name="familia_show")
         * @Method("GET")
         */
        public function showAction ( Familia $familium )
        {
            $deleteForm = $this->createDeleteForm( $familium );

            return $this->render(
                'familia/show.html.twig',
                array (
                    'familium'    => $familium,
                    'delete_form' => $deleteForm->createView(),
                )
            );
        }

        /**
         * Displays a form to edit an existing Familia entity.
         *
         * @Route("/{id}/edit", name="familia_edit")
         * @Method({"GET", "POST"})
         */
        public function editAction ( Request $request, Familia $familium )
        {
            $auth_checker = $this->get( 'security.authorization_checker' );
            if ( (($auth_checker->isGranted( 'ROLE_ADMIN' )) && ($familium->getUdala() == $this->getUser()->getUdala()))
                || ($auth_checker->isGranted( 'ROLE_SUPER_ADMIN' ))
            ) {
                $deleteForm = $this->createDeleteForm( $familium );
                $editForm = $this->createForm( 'Zerbikat\BackendBundle\Form\FamiliaType', $familium );
                $editForm->handleRequest( $request );

                if ( $editForm->isSubmitted() && $editForm->isValid() ) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist( $familium );
                    $em->flush();

                    return $this->redirectToRoute( 'familia_edit', array ('id' => $familium->getId()) );
                }

                $em = $this->getDoctrine()->getManager();
                $azpifamiliak = $em->getRepository( 'BackendBundle:Familia' )->findBy(
                    array (
                        'parent' => $familium->getId(),
                    )
                );

                return $this->render(
                    'familia/edit.html.twig',
                    array (
                        'familium'     => $familium,
                        'edit_form'    => $editForm->createView(),
                        'delete_form'  => $deleteForm->createView(),
                        'azpifamiliak' => $azpifamiliak,
                    )
                );
            } else {
                return $this->redirectToRoute( 'backend_errorea' );
            }
        }

        /**
         * Deletes a Familia entity.
         *
         * @Route("/{id}", name="familia_delete")
         * @Method("DELETE")
         */
        public function deleteAction ( Request $request, Familia $familium )
        {
            $auth_checker = $this->get( 'security.authorization_checker' );
            if ( (($auth_checker->isGranted( 'ROLE_ADMIN' )) && ($familium->getUdala() == $this->getUser()->getUdala()))
                || ($auth_checker->isGranted( 'ROLE_SUPER_ADMIN' ))
            ) {
                $form = $this->createDeleteForm( $familium );
                $form->handleRequest( $request );
                if ( $form->isSubmitted() && $form->isValid() ) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove( $familium );
                    $em->flush();
                }

                return $this->redirectToRoute( 'familia_index' );
            } else {
                //baimenik ez
                return $this->redirectToRoute( 'backend_errorea' );
            }
        }

        /**
         * Creates a form to delete a Familia entity.
         *
         * @param Familia $familium The Familia entity
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createDeleteForm ( Familia $familium )
        {
            return $this->createFormBuilder()
                ->setAction( $this->generateUrl( 'familia_delete', array ('id' => $familium->getId()) ) )
                ->setMethod( 'DELETE' )
                ->getForm();
        }
    }
