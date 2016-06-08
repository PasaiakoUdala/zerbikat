<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Fitxa;

class DefaultController extends Controller
{
    /**
     * @Route("/{udala}/")
     */
//    public function indexAction()
//    {
//        return $this->render('FrontendBundle:Default:index.html.twig');
//    }

//    /**
//     * Lists all Fitxa entities.
//     *
//     * @Route("/frontend/", name="fitxa_index")
//     * @Method("GET")
//     */
    public function indexAction($udala)
    {
        $em = $this->getDoctrine()->getManager();

//        $fitxas = $em->getRepository('BackendBundle:Fitxa')->findAll();

        $query = $em->createQuery('
          SELECT f FROM BackendBundle:Fitxa f
            WHERE f.udala = :udala
            ORDER BY f.kontsultak DESC 
        ');
        $query->setParameter('udala', $udala);
        $fitxak = $query->getResult();


        $query = $em->createQuery('
          SELECT f FROM BackendBundle:Familia f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', $udala);
        $familiak = $query->getResult();

        dump($familiak);

//        return $this->render('FrontendBundle:Default:index.html.twig', array(
        return $this->render('frontend\index.html.twig', array(
            'fitxak' => $fitxak,
            'familiak' => $familiak,
        ));
    }

}
