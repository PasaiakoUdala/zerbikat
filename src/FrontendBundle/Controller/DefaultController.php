<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Fitxa;

class DefaultController extends Controller
{

//    public function indexAction()
//    {
//        return $this->render('FrontendBundle:Default:index.html.twig');
//    }


    /**
     * @Route("/{udala}/{_locale}/", name="frontend_fitxa_index",
     *         requirements={
     *           "_locale": "eu|es",
     *           "udala": "\d+"
     *     }
     * )
     */

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
            'udala'=>$udala,
        ));
    }


    /**
     * Finds and displays a Fitxa entity.
     *
     * @Route("/{udala}/{_locale}/{id}", name="frontend_fitxa_show",
     *         requirements={
     *           "_locale": "eu|es",
     *           "udala": "\d+"
     *           }
     * )
     * @Method("GET")
     */
    public function showAction(Fitxa $fitxa,$udala)
    {
        $em = $this->getDoctrine()->getManager();
        $kanalmotak=$em->getRepository('BackendBundle:Kanalmota')->findAll();


        $query = $em->createQuery('
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.tramiteatext,f.tramiteatable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', $udala);
        //$eremuak = $query->getResult();
        $eremuak = $query->getSingleResult();

        $query = $em->createQuery('
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.tramitealabeleu,f.tramitealabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', $udala);
        $labelak = $query->getSingleResult();


        return $this->render('frontend/show.html.twig', array(
            'fitxa' => $fitxa,
            'kanalmotak'=>$kanalmotak,
            'eremuak'=> $eremuak,
            'labelak'=> $labelak,
            'udala' =>$udala,
        ));
    }

}
