<?php
namespace UserBundle\Controller;
//use Symfony\Bridge\Doctrine\Tests\Fixtures\User;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
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
        $query_str = parse_url($request->getUri(),PHP_URL_QUERY );
        dump($query_str);

        $urlOsoa=$request->getUri();
        dump($urlOsoa);
        $urlOsoa2=$request->getSchemeAndHttpHost().$_SERVER['REQUEST_URI'];
        dump($urlOsoa2);
        if (( $query_str != null )&&($this->container->getParameter('izfe_login_path')!='')) {
            dump("Lehen if BARRUAN");
            parse_str( $query_str, $query_params );
            /* GET kodea*/
            if ( $query_str != null )
            {
                $NA=$query_params["DNI"];
                $udala=$query_params["AYUN"];
                $hizkuntza=strtolower($query_params["IDIOMA"]);
                $fitxategia=$query_params["ficheroAuten"];

                dump("IZFELOGIN-era goaz");

                /** @var User $user */
                $user = $this->izfelogin($NA, $udala, $hizkuntza, $fitxategia, $urlOsoa, $urlOsoa2);

                dump("IFZELOGIN-etik bueltan erabiltzailea da:");
                dump($user);

                if ( $user !== null)
                {
                    dump("Dena ongi");
                    // Login egin duena IZFE-koa bada erabiltzaileen zerrenda, bestela fitxen zerrendara
                    if ($user->getUdala()->getId()===138) {
                        return $this->redirectToRoute( 'users_index', array('_locale'=> $hizkuntza ));
                    }

                    return $this->redirectToRoute( 'fitxa_index', array('_locale'=> $hizkuntza ));
                }
                else
                {
                    dump("Ez dago erabiltzailerik, beraz login-era goaz");
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
                }
            }
        }
        else
        {
            /** FOSUSERBUNDLE LoginAction */
            /** @var $session Session */
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

    private function izfelogin($NA,$udala,$hizkuntza,$fitxategia,$urlOsoa, $urlOsoa2)
    {
        dump("IZFE LOGIN-ek jasotako parametroak:");
        dump($udala);
        dump($hizkuntza);
        dump($fitxategia);
        dump($urlOsoa);
        dump($urlOsoa2);

        dump("fitxategia existitzen den begiratzen");
        /* fitxategiko kodea */
        if (file_exists ($this->container->getParameter('izfe_login_path').'/'.$fitxategia))
        {
            dump("Fitxategia existitzen da. Testua irakurtzen...");
            $fitx = fopen($this->container->getParameter('izfe_login_path').'/'.$fitxategia, 'rb');
            $lerro = fgets($fitx);
            $lerro = str_replace(array("\r", "\n"), '', $lerro);
            fclose( $fitx );
            dump("fitxategiak ondoko testua dauka:");
            dump($lerro);

            dump("URL-a eta fitxategi testua konparatzen");

            /* fitxategiaren edukia eta url-a berdinak diren konparatu*/
            if (($lerro == $urlOsoa)||($lerro==$urlOsoa2))
            {
                dump("berdinak dira, erabiltzailea bilatzen orain...");
                $userManager = $this->container->get('fos_user.user_manager');
                $user = $userManager->findUserBy([
                                                     'username' => $NA,
                                                     'udala'    => $udala
                                                 ]);
                dump($user);
                if (!$user) { // BEGIRATU IFZE-ko erabiltzailea den
                    dump("Ez da erabiltzailea aurkitu, IZFE-koa den begiratzen");
                    $user = $userManager->findUserBy([
                                             'username' => $NA,
                                             'udala'    => 138
                                             ]);
                    dump($user);
                }
                if (!$user) {
                    throw new UsernameNotFoundException(sprintf('Erabiltzailea ez da topatu'));
                }
                dump("Sesioa sortzen");
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));

                /* login-a egin ondoren fitxategia ezabatu */
                return $user;
            }
            return null;
        } return null;
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

        $deleteForms = array();
        foreach ($users as $user) {
            $deleteForms[$user->getId()] = $this->createDeleteForm($user)->createView();
        }

        return $this->render('UserBundle:Default:users.html.twig', array(
                'users' =>   $users,
                'deleteforms'=> $deleteForms,
            ));
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/user/new", name="user_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if(($auth_checker->isGranted('ROLE_ADMIN'))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $userManager = $this->container->get('fos_user.user_manager');
            $user = $userManager->createUser();
            $user->setEnabled( 1 );

            $user->setUdala($this->getUser()->getUdala());

            $form = $this->createForm('Zerbikat\BackendBundle\Form\UsernewwithpasswordType', $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPlainPassword( $user->getPassword());
                $userManager->updateUser($user, true);

//                return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
                return $this->redirectToRoute('users_index');
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
     * User Edit.
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
            if ($auth_checker->isGranted('ROLE_SUPER_ADMIN')) {
                $editForm = $this->createForm('Zerbikat\BackendBundle\Form\SuperuserType', $user);
            } else {
                $editForm = $this->createForm('Zerbikat\BackendBundle\Form\UserType', $user);
            }

            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $userManager = $this->container->get('fos_user.user_manager');
                $userManager->updateUser($user, true);

                return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
            }

            return $this->render('UserBundle:Default:edit.html.twig', array(
                'user' => $user,
                'form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Password Edit Password Action
     *
     * @Route("/user/{id}/passwd", name="user_edit_passwd")
     * @Method({"GET", "POST"})
     */
    public function passwdAction(Request $request, User $user)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($user->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\UserpasswdType', $user);

            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $userManager = $this->container->get('fos_user.user_manager');
                $user->setPlainPassword( $user->getPassword());
                $user->setEnabled( 1 );
                $userManager->updateUser($user, true);

                return $this->redirectToRoute('users_index');
            }

            return $this->render('UserBundle:Default:passwd.html.twig', array(
                'user' => $user,
                'form' => $editForm->createView()
            ));
        }else
        {
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
     * @return Form The form
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
