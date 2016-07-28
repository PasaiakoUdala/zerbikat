<?php
namespace UserBundle\Controller;
//use Symfony\Bridge\Doctrine\Tests\Fixtures\User;
use Zerbikat\BackendBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use GuzzleHttp;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Zerbikat\BackendBundle\BackendBundle;

use Zerbikat\BackendBundle\Form\UserType;

class SecurityController extends Controller
{
    public function loginAction ( Request $request )
    {
        /***
         * IZFE-rako login da ?
         * Baldin eta parametroa badu bai
         ***/
        $query_str = parse_url( $request->getSession()->get( '_security.main.target_path' ) );
        $miurl = $query_str['host'].'/'.$query_str['path'];
        $query_str = parse_url( $request->getSession()->get( '_security.main.target_path' ), PHP_URL_QUERY );

        $urlOsoa= $request->getSession()->get( '_security.main.target_path' );

        if (( $query_str != null )&&($this->container->getParameter('izfe_login_path')!='')) {
            parse_str( $query_str, $query_params );
            /* GET kodea*/
            if ( $query_str != null )
            {
                $NA=$query_params["DNI"];
                $udala=$query_params["AYUN"];
                $hizkuntza=$query_params["IDIOMA"];
                $fitxategia=$query_params["ficheroAuten"];


                if ($this->izfelogin ($NA,$udala,$hizkuntza,$fitxategia,$urlOsoa)==1)
                {
                        return $this->redirectToRoute( 'fitxa_index' );
                }else
                {
//                        dump("else");
                        $lastUsername = null;
                        $csrfToken = $this->get( 'security.csrf.token_manager' )->getToken( 'authenticate' )->getValue();
                        $error = null;
                        return $this->renderLogin(
                            array (
                                'last_username' => $lastUsername,
                                'error'         => $error,
                                'csrf_token'    => $csrfToken,
                            )
                        );
//                        return $this->render( 'FOSUserBundle:Security:login.html.twig', $data );
                }
            }
        }
        else
        {
            /** FOSUSERBUNDLE LoginAction */
            /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
            $session = $request->getSession();
            if ( class_exists( '\Symfony\Component\Security\Core\Security' ) ) {
                $authErrorKey = Security::AUTHENTICATION_ERROR;
                $lastUsernameKey = Security::LAST_USERNAME;
            } else {
                // BC for SF < 2.6
                $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
                $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
            }
            // get the error if any (works with forward and redirect -- see below)
            if ( $request->attributes->has( $authErrorKey ) ) {
                $error = $request->attributes->get( $authErrorKey );
            } elseif ( null !== $session && $session->has( $authErrorKey ) ) {
                $error = $session->get( $authErrorKey );
                $session->remove( $authErrorKey );
            } else {
                $error = null;
            }
            if ( !$error instanceof AuthenticationException ) {
                $error = null; // The value does not come from the security component.
            }
            // last username entered by the user
            $lastUsername = (null === $session) ? '' : $session->get( $lastUsernameKey );
            if ( $this->has( 'security.csrf.token_manager' ) ) {
                $csrfToken = $this->get( 'security.csrf.token_manager' )->getToken( 'authenticate' )->getValue();
            } else {
                // BC for SF < 2.4
                $csrfToken = $this->has( 'form.csrf_provider' )
                    ? $this->get( 'form.csrf_provider' )->generateCsrfToken( 'authenticate' )
                    : null;
            }
            return $this->renderLogin(
                array (
                    'last_username' => $lastUsername,
                    'error'         => $error,
                    'csrf_token'    => $csrfToken,
                )
            );
        }
    }
    protected function renderLogin ( array $data )
    {
        return $this->render( 'FOSUserBundle:Security:login.html.twig', $data );
    }


    private function izfelogin($NA,$udala,$hizkuntza,$fitxategia,$urlOsoa)
    {
        /* fitxategiko kodea */
//        $fitx = fopen($this->container->getParameter('izfe_login_path').'/'.$fitxategia,"r") or die("Unable to open file!");
        /* fitxategia ez bada existitzen login orrira berbideratu */
        if (file_exists ($this->container->getParameter('izfe_login_path').'/'.$fitxategia))
        {
            $fitx = fopen($this->container->getParameter('izfe_login_path').'/'.$fitxategia,"r");
            $lerro = fgets($fitx);

//            dump ("URL-a: ".$urlOsoa);
//            dump ("Fitxategia: ".$lerro);

            /* fitxategiaren edukia eta url-a berdinak diren konparatu*/
            if ($lerro == $urlOsoa)
            {
                $userManager = $this->container->get('fos_user.user_manager');
                $user = $userManager->findUserByUsername($NA);

                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                /* login-a egin ondoren fitxategia ezabatu */
//                unlink($this->container->getParameter('izfe_login_path') . '/' . $fitxategia);
                return 1;
            }
            return 0;
        } return 0;
    }
    

    

    
    /**
     * Lists all USERS .
     *
     * @Route("/user", defaults={"page" = 1}, name="users_index")
     * @Route("user/page{page}", name="user_index_paginated")
     * @Method("GET")
     */
    public function userAction($page) {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();


        $adapter = new ArrayAdapter($users);
        $pagerfanta = new Pagerfanta($adapter);

        $deleteForms = array();
        foreach ($users as $user) {
            $deleteForms[$user->getId()] = $this->createDeleteForm($user)->createView();
        }
        try {
            $entities = $pagerfanta
                ->setMaxPerPage($this->getUser()->getUdala()->getOrrikatzea())
                ->setCurrentPage($page)
                ->getCurrentPageResults()
            ;
        } catch (\Pagerfanta\Exception\NotValidCurrentPageException $e) {
            throw $this->createNotFoundException("Orria ez da existitzen");
        }

        return $this->render('UserBundle:Default:users.html.twig', array(
//                'users' =>   $users,
                'users' => $entities,
                'pager' => $pagerfanta,
                'deleteforms'=> $deleteForms,
            ));
    }



    /**
     * Creates a new User entity.
     *
     * @Route("/user/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if(($auth_checker->isGranted('ROLE_ADMIN'))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $user = new User();
            $user->setUdala($this->getUser()->getUdala());

            $form = $this->createForm('Zerbikat\BackendBundle\Form\UserType', $user);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();

            if ($form->isSubmitted() && $form->isValid()) {
//                dump($user);
                $em->persist($user);
                $em->flush();

//                return $this->redirectToRoute('fitxa_show', array('id' => $fitxa->getId()));
                return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
            } else
            {
//                dump($form->isValid());
//                $form->getData()->setUdala($this->getUser()->getUdala());
//                $form->setData($form->getData());
            }

            return $this->render('UserBundle:Default:new.html.twig', array(
                'user' => $user,
                'form' => $form->createView(),
            ));
        }
    }


    /**
     * Finds and displays a User entity.
     *
     * @Route("/user/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('UserBundle:Default:show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }





    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/user/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($user->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($user);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\UserType', $user);
//            $editForm = $this->createForm(new UserType('Zerbikat\BackendBundle\Form\UserType'), $user);
            $editForm->handleRequest($request);
//
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
            }

            return $this->render('UserBundle:Default:edit.html.twig', array(
                'user' => $user,
                'form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
//            return $this->redirectToRoute('fitxa_index');
            return $this->redirectToRoute('backend_errorea');
        }
    }



    /**
     * Deletes a User entity.
     *
     * @Route("/user/{id}/del", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        //udala egokia den eta admin baimena duen egiaztatu
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($user->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($user);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
            }else
            {

            }
            return $this->redirectToRoute('users_index');
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }




    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    


}