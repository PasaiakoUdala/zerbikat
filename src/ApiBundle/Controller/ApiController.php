<?php
    /**
     * User: iibarguren
     * Date: 31/05/16
     * Time: 10:09
     */

    namespace ApiBundle\Controller;


    use AppBundle\Form\AtalaType;

    use FOS\RestBundle\Controller\Annotations;
    use FOS\RestBundle\Controller\FOSRestController;
    use FOS\RestBundle\Request\ParamFetcherInterface;
    use FOS\RestBundle\View\View;

    use Nelmio\ApiDocBundle\Annotation\ApiDoc;

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Form\FormTypeInterface;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    use Zerbikat\BackendBundle\Entity\Fitxa;

    class ApiController extends FOSRestController
    {

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
         * @return array data
         *
         * @Annotations\View()
         */
        public function getFamiliakAction ( $udala )
        {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                '
          SELECT f
            FROM BackendBundle:Familia f
              INNER JOIN f.udala u
            WHERE u.kodea = :udala
        '
            );
            $query->setParameter( 'udala', $udala );
            $familiak = $query->getResult();

            $query = $em->createQuery(
                '
          SELECT f
            FROM BackendBundle:Fitxa f
              INNER JOIN f.udala u
            WHERE u.kodea = :udala
            ORDER BY f.kontsultak
        '
            );
            $query->setMaxResults( 10 );
            $query->setParameter( 'udala', $udala );
            $kontsul = $query->getResult();
            array_push( $familiak, $kontsul );

            $view = View::create();
            $view->setData( $familiak );

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
         * @return array data
         *
         * @Annotations\View()
         */
        public function getAzpifamiliakAction ( $id )
        {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                '
          SELECT f
            FROM BackendBundle:Familia f              
            WHERE f.parent = :id
        '
            );
            $query->setParameter( 'id', $id );
            $azpifamiliak = $query->getResult();

            $view = View::create();
            $view->setData( $azpifamiliak );

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
         * @return array data
         *
         * @Annotations\View()
         */
        public function getFitxakAction ( $id )
        {
            $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery(
                '
            SELECT f.id,f.espedientekodea,f.deskribapenaeu,f.deskribapenaes
            FROM BackendBundle:Fitxa f
              LEFT JOIN f.familiak ff
            WHERE ff.id = :id AND f.publikoa=1
        '
            );

            $query->setParameter( 'id', $id );


            $fitxak = $query->getResult( \Doctrine\ORM\Query::HYDRATE_ARRAY );

//        $arr=[];
//        foreach ($fitxak as $f)  {
//            $fitxa = New Fitxa();
//            $fitxa->setId($f['id']);
//            if (is_null($f['espedientekodea']))
//                $fitxa->setEspedientekodea('');
//            else $fitxa->setEspedientekodea($f['espedientekodea']);
//            $fitxa->setDeskribapenaeu($f['deskribapenaeu']);
//            $fitxa->setDeskribapenaes($f['deskribapenaes']);
//           array_push($arr, $fitxa);
//        }

//        $fitxak = $query->getResult();
            $view = View::create();
//        $view->setData($arr);
            $view->setData( $fitxak );

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
         * @return array data
         *
         * @Annotations\View()
         */
        public function getFitxaAction ( Fitxa $fitxa )
        {
            $em = $this->getDoctrine()->getManager();

            $fitxa = $em->getRepository( 'BackendBundle:Fitxa' )->findOneBy( array ('id' => 12) );

            $query = $em->createQuery(
                '
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f
            WHERE f.udala=:udala
        '
            );
            $query->setParameter( 'udala', $fitxa->getUdala() );
            $eremuak = $query->getSingleResult();

            $query = $em->createQuery(
                '
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f
            WHERE f.udala=:udala
        '
            );
            $query->setParameter( 'udala', $fitxa->getUdala() );
            $labelak = $query->getSingleResult();


            $kanalmotak = $em->getRepository( 'BackendBundle:Kanalmota' )->findAll();

            $response = new Response();
//        $response->headers->set('Content-Type', 'xml');
            $response->headers->set( 'Content-Type', 'application/xml; charset=utf-8' );

            return $this->render(
                'fitxapi.xml.twig',
                array (
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
         * @return array data
         *
         * @Annotations\View()
         */
        public function getFamiliaordenaAction ( $id )
        {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                '
                SELECT f
                FROM BackendBundle:Familia f              
                WHERE f.id = :id
                '
            );
            $query->setParameter( 'id', $id );
            $familia = $query->getResult();

            $ordena =(int) $familia->getOrdena();
            $ordena+=1;

            $view = View::create();
            $view->setData( $ordena );

            return $view;

        }// "get_familiaorden"            [GET] /familiaorden/{id}

    }