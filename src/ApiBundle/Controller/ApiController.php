<?php
/**
 * User: iibarguren
 * Date: 31/05/16
 * Time: 10:09
 */

namespace ApiBundle\Controller;


use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Zerbikat\BackendBundle\Entity\Familia;
use Zerbikat\BackendBundle\Entity\Fitxa;

class ApiController extends FOSRestController
{

    /**
     * Fitxa baten deskribapena, saila eta azpisaila eskuratu fitxaren eta udalaren kodea erabiliz
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Fitxa baten deskribapena, saila eta azpisaila eskuratu fitxaren kodea erabiliz",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @param $udala
     * @param $kodea
     *
     * @return array|View
     * @Annotations\View()
     *
     * @Get("/fitxadatuakbykodea/{udala}/{kodea}")
     */
    public function getFitxaDatuakByKodeaAction ($udala, $kodea) {


        $em = $this->getDoctrine()->getManager();
        /** @var QueryBuilder $query */
        $query = $em->createQueryBuilder('f');
        $query->from( 'BackendBundle:Fitxa', 'f' );
        $query->select( 'f.id, f.espedientekodea, f.deskribapenaeu, f.deskribapenaes', 'az.id', 'az.azpisailaes', 'az.azpisailaeu', 's.id', 's.sailaeu', 's.sailaes' );
        $query->leftJoin( 'f.udala', 'u' );
        $query->innerJoin('f.azpisaila', 'az');
        $query->innerJoin('az.saila', 's');
        $query->andWhere( 'u.kodea = :udala' );
        $query->setParameter( 'udala', $udala );
        $query->andWhere( 'f.espedientekodea = :kodea' );
        $query->setParameter( 'kodea', $kodea );


        $fitxa = $query->getQuery()->getResult();
        $view = View::create();
        $view->setData( $fitxa );

        header('content-type: application/json; charset=utf-8');
        header('access-control-allow-origin: *');
        return $view;
    }


    /****************************************************************************************************************
     ****************************************************************************************************************
     **** API SAC ***************************************************************************************************
     ****************************************************************************************************************
     ****************************************************************************************************************/

    /**
     * Udal baten Sail zerrenda
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Udal baten sail zerrenda",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @param $udala
     *
     * @return array|View
     * @Annotations\View()
     *
     * @Get("/sailak/{udala}")
     */
    public function getSailakAction( $udala )
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Query $query */
        $query = $em->createQuery(
            /** @lang text */
            '
            SELECT s
              FROM BackendBundle:Saila s
              INNER JOIN s.udala u
            WHERE u.kodea = :udala
            ORDER BY s.kodea DESC
            '
        );
        $query->setParameter( 'udala', $udala );
        $sailak = $query->getResult();

        header('content-type: application/json; charset=utf-8');
        header('access-control-allow-origin: *');
        if ( $sailak === null ) {
            return new View( 'there are no users exist', Response::HTTP_NOT_FOUND );
        }


        return $sailak;

    }

    /**
     * Udal baten Azpisail baten fitxa zerrenda
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Udal baten Azpisail baten fitxa zerrenda",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     * @param $azpisailaid
     *
     * @return array|View
     * @Annotations\View(serializerGroups={"kontakud"})
     *
     * @Get("/azpisailenfitxak/{azpisailaid}")
     */
    public function getAzpisailenfitxakAction( $azpisailaid)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Query $query */
        $query = $em->createQuery(
        /** @lang text */
            '
            SELECT f
              FROM BackendBundle:Fitxa f
              INNER JOIN f.azpisaila a
              WHERE a.id = :azpisailaid
            '
        );
        $query->setParameter( 'azpisailaid', $azpisailaid );
        $fitxak = $query->getResult();

        header('content-type: application/json; charset=utf-8');
        header('access-control-allow-origin: *');
        if ( $fitxak === null ) {
            return new View( 'there are no users exist', Response::HTTP_NOT_FOUND );
        }

        return $fitxak;

    }

    /**
     * Udal baten Familia/Azpifamilia zerrenda
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Udal baten Familia/Azpifamilia zerrenda",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @param $udala
     *
     * @return array|View
     * @Annotations\View()
     *
     * @Get("/familisarea/{udala}")
     */
    public function getFamilisareaAction( $udala )
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Query $query */
        $query = $em->createQuery(
        /** @lang text */
            '
            SELECT s
              FROM BackendBundle:Saila s
              LEFT JOIN BackendBundle:Udala u
            WHERE u.kodea = :udala
            ORDER BY s.kodea DESC
            '
        );
        $query->setParameter( 'udala', $udala );
        $sailak = $query->getResult();

        header('content-type: application/json; charset=utf-8');
        header('access-control-allow-origin: *');
        if ( $sailak === null ) {
            return new View( 'there are no users exist', Response::HTTP_NOT_FOUND );
        }

        return $sailak;

    }

    /**
     * Udal baten Fitxa eskuratu kodea-ren bidez
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Udal baten Fitxa eskuratu kodea-ren bidez",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @param $udala
     * @param $kodea
     *
     * @return array|View
     * @Annotations\View()
     *
     * @Get("/fitxabykodea/{udala}/{kodea}")
     */
    public function getFitxaByKodeaAction ($udala, $kodea) {


        $em = $this->getDoctrine()->getManager();
        /** @var QueryBuilder $query */
        $query = $em->createQueryBuilder('f');
        $query->from( 'BackendBundle:Fitxa', 'f' );
        $query->select( 'f.id, f.espedientekodea, f.deskribapenaeu, f.deskribapenaes' );
        $query->leftJoin( 'f.udala', 'u' );
        $query->andWhere( 'u.kodea = :udala' );
        $query->setParameter( 'udala', $udala );
        $query->andWhere( 'f.espedientekodea = :kodea' );
        $query->setParameter( 'kodea', $kodea );


        $fitxa = $query->getQuery()->getResult();
        $view = View::create();
        $view->setData( $fitxa );

        header('content-type: application/json; charset=utf-8');
        header('access-control-allow-origin: *');
        return $view;
    }

    /****************************************************************************************************************
     ****************************************************************************************************************
     **** FIN API SAC ***********************************************************************************************
     ****************************************************************************************************************
     ****************************************************************************************************************/

    /**
     * Familia guztien zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Bloke guztiak eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @param $udala
     *
     * @return array|View
     *
     * @Annotations\View()
     */
    public function getFamiliakAction( $udala )
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Query $query */
        $query = $em->createQuery(
            '
          SELECT f
            FROM BackendBundle:Familia f
              INNER JOIN f.udala u
            WHERE u.kodea = :udala
            ORDER BY f.ordena
        '
        );
        $query->setParameter( 'udala', $udala );
        $familiak = $query->getResult();

        $view = View::create();
        $view->setData( $familiak );

        header('content-type: application/json; charset=utf-8');
        header('access-control-allow-origin: *');
        return $view;

    }// "get_familiak"            [GET] /familiak/{udala}

    /**
     * Familia baten azpifamiliak zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Familia baten azpifamiliak zerrenda.",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @param $id
     *
     * @return array|View
     *
     * @Annotations\View()
     */
    public function getAzpifamiliakAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Query $query */
        $query = $em->createQuery(
            '
          SELECT f
            FROM BackendBundle:Familia f
            WHERE f.parent = :id
            ORDER BY f.ordena

        '
        );
        $query->setParameter('id', $id);
        $azpifamiliak = $query->getResult();

        $view = View::create();
        $view->setData($azpifamiliak);
        header('content-type: application/json; charset=utf-8');
        header('access-control-allow-origin: *');

        return $view;

    }// "get_azpifamiliak"            [GET] /azpifamiliak/{id}

    /**
     * Familia baten fitxa guztien zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Familia baten fitxak eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @param $id
     *
     * @return array|View
     *
     * @Annotations\View()
     */
    public function getFitxakAction( $id )
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Query $query */
        $query = $em->createQuery(
            /** @lang text */
            '
            SELECT f.id,f.espedientekodea,f.deskribapenaeu,f.deskribapenaes
            FROM BackendBundle:Fitxa f
              LEFT JOIN f.fitxafamilia ff
              LEFT JOIN ff.familia fa
            WHERE f.publikoa=1 AND fa.id=:id
            '
        );

        $query->setParameter( 'id', $id );


        $fitxak = $query->getResult( Query::HYDRATE_ARRAY );


        $view = View::create();
        $view->setData( $fitxak );
        header('content-type: application/json; charset=utf-8');
        header('access-control-allow-origin: *');

        return $view;

    }// "get_fitxak"            [GET] /fitxak/{id}

    /**
     * Fitxa irakurri.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Fitxa irakurri",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @param Fitxa $fitxa
     *
     * @return array|Response
     *
     * @Annotations\View()
     */
    public function getFitxaAction( Fitxa $fitxa )
    {
        $em = $this->getDoctrine()->getManager();
        $eremuak = null;
        $labelak = null;

        /** @var Query $query */
        $query = $em->createQuery(
            /** @lang text */
            '
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f
            WHERE f.udala=:udala
        '
        );
        $query->setParameter( 'udala', $fitxa->getUdala() );
        try {
            $eremuak = $query->getSingleResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

        $query = $em->createQuery(
            /** @lang text */
            '
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f
            WHERE f.udala=:udala
        '
        );
        $query->setParameter( 'udala', $fitxa->getUdala() );
        try {
            $labelak = $query->getSingleResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }


        $kanalmotak = $em->getRepository( 'BackendBundle:Kanalmota' )->findAll();

        $response = new Response();
        $response->headers->set( 'Content-Type', 'application/xml; charset=utf-8' );
        return $this->render(
            'fitxapi.xml.twig',
            array(
                'fitxa'      => $fitxa,
                'eremuak'    => $eremuak,
                'labelak'    => $labelak,
                'kanalmotak' => $kanalmotak,
            ),
            $response
        );
    }// "get_fitxa"            [GET] /fitxa/{id}

    /**
     * Familia baten ordena sugeritu.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Familia baten ordena sugeritu.",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @param $id
     *
     * @return View data
     *
     * @Annotations\View()
     */
    public function getFamiliaordenaAction( $id )
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Query $query */
        $query = $em->createQuery(
            '
                SELECT f
                FROM BackendBundle:Familia f
                WHERE f.id = :id
                '
        );
        $query->setParameter( 'id', $id );
        /** @var Familia $familia */
        $familia = $query->getResult();

        $ordena = (int)$familia->getOrdena();
        ++$ordena;

        $view = View::create();
        $view->setData( $ordena );

        return $view;

    }// "get_familiaorden"            [GET] /familiaorden/{id}

}
