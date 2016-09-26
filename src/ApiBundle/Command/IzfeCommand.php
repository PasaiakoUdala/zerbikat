<?php

    namespace ApiBundle\Command;

    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Question\ChoiceQuestion;
    use Symfony\Component\Filesystem\Filesystem;
    use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
    use Zerbikat\BackendBundle\Entity\Udala;
    use Symfony\Component\Console\Helper\ProgressBar;
    use Symfony\Component\Console\Question\ConfirmationQuestion;

    class IzfeCommand extends ContainerAwareCommand
    {

        /**
         * {@inheritdoc}
         */
        protected function configure ()
        {
            $this
                ->setName( 'api:izfe' )
                ->setDescription( 'Zerbitzu telematikoen fitxategia sortu' )
                ->addArgument( 'udalKodea', InputArgument::REQUIRED, 'Udal kodea, adibidez pasaiarentzat 064.' );
        }


        function addOrria ( $A204AYUNTA, $IdPagina, $denomi, $titcast, $titeus, $publicada, $tipo )
        {
            $denomi = addslashes   ( $denomi );
            $titcast = addslashes   ( $titcast );
            $titeus = addslashes   ( $titeus );

            $A204IDPAGINA = $IdPagina;
            $A204DENOMI = "'Home ".$denomi."'";
            $A204DENOMI = "'" .mb_strimwidth( $denomi, 0, 96). "'";
            $A204TITCAST = "'Inicio ".$titcast."'";
            $A204TITCAST = "'" . mb_strimwidth( "Inicio ".$titcast, 0, 96, "..." ). "'";
            $A204TITEUSK = "'".$titeus." Hasiera'";
            $A204TITEUSK = "'" . mb_strimwidth( "Inicio ".$titcast, 0, 96, "..." ). "'";
            $A204PUBLICADA = $publicada;
//            $A204FECALTA = date( 'Ymd' );
            $A204FECALTA = null;

            switch ( $tipo ) {
                case "USC":
                    $A204TIPO = "'HOME'";
                    break;
                case "UXX":
                    $A204TIPO = "'PROPIA'";
                    break;
                default:
                    $servicios = array (
                        "UML",
                        "UPF",
                        "URM",
                        "UEX",
                        "UPM-PM",
                        "UPM-PV",
                        "UPM-CE",
                        "UPM-HE",
                        "URG",
                        "URA",
                        "URB",
                        "UVD",
                    );

                    if ( in_array( $tipo, $servicios ) ) {
                        $A204TIPO = "'SERVICIO'";
                    } else {
                        $A204TIPO = "'EXPEDIENTE'";
                    }
            }

            $A204IDTIPO = "'".$tipo."'";
            $sql = "INSERT INTO UDAA20401 (A204AYUNTA,A204IDPAGINA,A204DENOMI,A204TITCAST,A204TITEUSK,A204PUBLICADA,A204FECALTA,A204TIPO,A204IDTIPO)
            VALUES ($A204AYUNTA, $A204IDPAGINA, $A204DENOMI, $A204TITCAST, $A204TITEUSK, $A204PUBLICADA, null, $A204TIPO, $A204IDTIPO);\n";

            return $sql;
        }

        function addBloque ( $A204AYUNTA, $idBlokea, $titeus, $tites )
        {
            $A203AYUNTA = $A204AYUNTA;
            $A203IDBLOQUE = $idBlokea;
            $A203DENOMI = "'".$idBlokea." Blokea'";
            $A203DENOMI = mb_strimwidth( $A203DENOMI, 0, 96, "...'" );
            $A203TITCAST = "'".$tites."'";
            $A203TITEUSK = "'".$titeus."'";
//            $A203FECALTA = date( 'Ymd' );
            $A203FECALTA = null;

            $sql = "INSERT INTO UDAA20301 (A203AYUNTA,A203IDBLOQUE,A203DENOMI,A203TITCAST,A203TITEUSK,A203FECALTA)
            VALUES($A203AYUNTA, $A203IDBLOQUE, $A203DENOMI, $A203TITCAST, $A203TITEUSK, null);\n";

            return $sql;
        }

        function addOrriaBloque ( $A204AYUNTA, $idPagina, $idBlokea, $idOrden )
        {
            $A206AYUNTA = $A204AYUNTA;
            $A206IDPAGINA = $idPagina;
            $A206IDBLOQUE = $idBlokea;
            $A206ORDEN = $idOrden;
            $A206VISUAL = 1;

            $sql = "INSERT INTO UDAA20601 (A206AYUNTA,A206IDPAGINA,A206IDBLOQUE,A206ORDEN,A206VISUAL) 
                VALUES($A206AYUNTA, $A206IDPAGINA, $A206IDBLOQUE, $A206ORDEN, $A206VISUAL);\n";

            return $sql;
        }

        function addElementua ( $A204AYUNTA, $idElementua, $denomi, $titcast, $titeus, $tipo, $link = '' )
        {
            $denomi = addslashes   ( $denomi );
            $titcast = addslashes   ( $titcast );
            $titeus = addslashes   ( $titeus );

            $A202AYUNTA = $A204AYUNTA;
            $A202IDLINEA = $idElementua;
            $A202DENOMI = "'".$denomi."'";
            $A202DENOMI = mb_strimwidth( $A202DENOMI, 0, 96, "...'" );
            $A202TEXCAST = "'".$titcast."'";
            $A202TEXCAST = mb_strimwidth( $A202TEXCAST, 0, 495, "...'" );
            $A202TEXEUSK = "'".$titeus."'";
            $A202TEXEUSK = mb_strimwidth( $A202TEXEUSK, 0, 495, "...'" );
            $A202SERVICIO = "'".$tipo."'";
            if ( $tipo == "PROPIA" ) {
                $A202LINKEXT = "'".$link."'";
            } else {
                $A202LINKEXT = "''";
            }
//            $A202FECALTA = date( 'Ymd' );
            $A202FECALTA = null;

            $sql = "INSERT INTO UDAA20201 (A202AYUNTA, A202IDLINEA, A202DENOMI, A202TEXCAST, A202TEXEUSK, A202LINKEXT, A202SERVICIO,A202FECALTA)
                               VALUES($A202AYUNTA, $A202IDLINEA, $A202DENOMI, $A202TEXCAST, $A202TEXEUSK, $A202LINKEXT, $A202SERVICIO, null);\n";

            return $sql;
        }

        function addElementuaBloque ( $A204AYUNTA, $idBlokea, $idElementua, $idOrdenElementua )
        {
            $sql = "INSERT INTO UDAA20501 (A205AYUNTA,A205IDBLOQUE,A205IDLINEA,A205ORDEN)
            VALUES($A204AYUNTA, $idBlokea, $idElementua, $idOrdenElementua);\n";

            return $sql;
        }

        /**
         * {@inheritdoc}
         */
        protected function execute ( InputInterface $input, OutputInterface $output )
        {
            $udalKodea = $input->getArgument( 'udalKodea' );
            $filename = "web/doc/$udalKodea/izfesql.sql";

            $em = $this->getContainer()->get( 'doctrine' )->getManager();

            $udala = $em->getRepository( 'BackendBundle:Udala' )->findOneBy(
                array (
                    'kodea' => $udalKodea,
                )
            );



            $output->writeln(
                [
                    '',
                    '<info>===============================</info>',
                    'Aukeratutako udala => '.$udala->getIzenaeu(),
                    'Sortuko den fitxategia => '.$filename,
                    '<info>===============================</info>',
                    '',
                    '',
                ]
            );

            // Fitxa bat sortzen
            $fitxak = $em->getRepository( 'BackendBundle:Fitxa' )->findAll(
                array (
                    'publikoa' => 1,
                    'udala_id' => $udala->getId(),
                )
            );


            $helper = $this->getHelper( 'question' );
            $question = new ChoiceQuestion(
                'Datuak zuzenak dira? Horrela bada tauletako datuak ezabatuko dira.',
                array ('Bai', 'Ez'),
                null
            );

            $color = $helper->ask( $input, $output, $question );

            if ( $color === 'Ez' ) {
                $output->writeln(
                    [
                        '',
                        '<info>===============================</info>',
                        'Erabiltzaileak prozesua ezeztatu du.',
                        '<info>===============================</info>',
                        '',
                        '',
                    ]
                );

                return;
            }


            /** CONFIGURAZIOA */
            $COUNT_FITXA = count( $fitxak );
            $idPagina = 1;
            $idBlokea = 1;
            $idOrden = 1;
            $idOrdenElementua = 1;
            $idElementua = 1;
            $A204AYUNTA = "'".$udalKodea."'";

            $sql = "DELETE FROM UDAA20401 WHERE A204AYUNTA=$A204AYUNTA;\n"; // Orriak
            $sql = $sql."DELETE FROM UDAA20201 WHERE A202AYUNTA=$A204AYUNTA;\n"; // Elementuak
            $sql = $sql."DELETE FROM UDAA20301 WHERE A203AYUNTA=$A204AYUNTA;\n"; // Blokeak
            $sql = $sql."DELETE FROM UDAA20501 WHERE A205AYUNTA=$A204AYUNTA;\n"; // Blokeak - Elementuak
            $sql = $sql."DELETE FROM UDAA20601 WHERE A206AYUNTA=$A204AYUNTA;\n"; // Orriak - Blokeak


            $output->writeln( [$COUNT_FITXA.' aurkitu dira.', ''] );

            $progress = new ProgressBar( $output, $COUNT_FITXA );
            $progress->start();

            $kanalmotak = $em->getRepository( 'BackendBundle:Kanalmota' )->findAll();
            $query = $em->createQuery(
                '
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        '
            );
            $query->setParameter( 'udala', $udala->getId() );
            $eremuak = $query->getSingleResult();

            $query = $em->createQuery(
                '
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        '
            );
            $query->setParameter( 'udala', $udala->getId() );
            $labelak = $query->getSingleResult();


            $query = $em->createQuery(
                '
          SELECT f FROM BackendBundle:Familia f LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
            WHERE u.kodea = :udala
        '
            );
            $query->setParameter( 'udala', $udalKodea );
            $familiak = $query->getResult();

            /*******************************************************************/
            /**** Home-a sortu  ************************************************/
            /*******************************************************************/
            $sql = $sql.$this->addOrria(
                    $A204AYUNTA,
                    $idPagina,
                    "Home ".$udala->getIzenaeu(),
                    "Inicio ".$udala->getIzenaes(),
                    $udala->getIzenaeu()." Hasiera",
                    1,
                    "USC"
                );
            $idPaginaHome = $idPagina;
            $idPagina += 1;

            $sql = $sql.$this->addBloque( $A204AYUNTA, $idBlokea, "Froga", "Prueba" );
            $idBlokeaHome = $idBlokea;
            $idBlokea += 1;

            $sql = $sql.$this->addOrriaBloque( $A204AYUNTA, $idPaginaHome, $idBlokeaHome, $idOrden );
            $idOrden += 1;

            /*******************************************************************/
            /**** Fitxak-a sortu  ************************************************/
            /*******************************************************************/
            foreach ( $fitxak as $fitxa ) {
                // Orria sortu fitxarentzat
                $sql = $sql.$this->addOrria(
                        $A204AYUNTA,
                        $idPagina,
                        $fitxa->getEspedientekodea(),
                        $fitxa->getEspedientekodea(),
                        $fitxa->getDeskribapenaeu(),
                        1,
                        "UXX"
                    );
                // Esteka sortu Home-an
                $sql = $sql.$this->addElementua(
                        $A204AYUNTA,
                        $idElementua,
                        $fitxa->getEspedientekodea(),
                        $fitxa->getEspedientekodea(),
                        $fitxa->getEspedientekodea(),
                        "PROPIA",
                        $idPagina
                    );
                $sql = $sql.$this->addElementuaBloque( $A204AYUNTA, $idBlokeaHome, $idElementua, $idOrdenElementua );
                $idOrdenElementua += 1;
                $idElementua += 1;


                /****** HASI HELBURUA *********************************************************************/
                if ( $eremuak['helburuatext'] ) {
                    $sql = $sql.$this->addBloque($A204AYUNTA,$idBlokea,$labelak['helburualabeles'],$labelak['helburualabeleu']);
                    $sql = $sql.$this->addOrriaBloque( $A204AYUNTA, $idPagina, $idBlokea, $idOrden );
                    $sql = $sql.$this->addElementua($A204AYUNTA,$idElementua,"Texto",$fitxa->getHelburuaes(),$fitxa->getHelburuaeu(),"PARRAFO");
                    $sql = $sql.$this->addElementuaBloque( $A204AYUNTA, $idBlokea, $idElementua, $idOrdenElementua );
                    $idBlokea += 1;
                    $idOrden += 1;
                    $idOrdenElementua += 1;
                    $idElementua += 1;
                }
                /****** FIN HELBURUA *********************************************************************/

                /****** HASI NORK ESKATU *********************************************************************/
                if ( ($eremuak['norkeskatutext']) || ($eremuak['norkeskatutable']) ) {
                    $sql = $sql.$this->addBloque($A204AYUNTA,$idBlokea,$labelak['norkeskatulabeles'],$labelak['norkeskatulabeleu']);
                    $sql = $sql.$this->addOrriaBloque( $A204AYUNTA, $idPagina, $idBlokea, $idOrden );

                    if ( $eremuak['norkeskatutext'] ) {
                        $sql = $sql.$this->addElementua($A204AYUNTA,$idElementua,"Texto",$fitxa->getNorkes(),$fitxa->getNorkeu(),"PARRAFO");
                        $sql = $sql.$this->addElementuaBloque($A204AYUNTA,$idBlokea,$idElementua,$idOrdenElementua);
                        $idElementua += 1;
                        $idOrdenElementua += 1;
                    }
                    if ( $eremuak["norkeskatutable"] ) {
                        if ($fitxa->getNorkeskatuak() ) {
                            foreach ( $fitxa->getNorkeskatuak() as $nork ) {
                                $sql = $sql.$this->addElementua($A204AYUNTA,$idElementua,"Texto",$nork->getNorkes(),$nork->getNorkeu(),"PARRAFO");
                                $sql = $sql.$this->addElementuaBloque($A204AYUNTA,$idBlokea,$idElementua,$idOrdenElementua);
                                $idElementua += 1;
                                $idOrdenElementua += 1;
                            }
                        }
                    }
                    $idBlokea += 1;
                    $idOrden += 1;
                }
                /****** FIN NORK ESKATU *********************************************************************/

                /****** HASI DOKUMENTAZIOA *********************************************************************/
                if ( ($eremuak['dokumentazioatext']) || ($eremuak['dokumentazioatable']) ) {
                    $sql = $sql.$this->addBloque($A204AYUNTA,$idBlokea,$labelak['dokumentazioalabeles'],$labelak['dokumentazioalabeleu']);
                    $sql = $sql.$this->addOrriaBloque( $A204AYUNTA, $idPagina, $idBlokea, $idOrden );

                    if ( $eremuak["dokumentazioatable"] ) {
                        if ($fitxa->getDokumentazioak() ) {
                            $doctextes = "<ul>";
                            $doctexteu = "<ul>";
                            foreach ( $fitxa->getDokumentazioak() as $doc ) {
                                $doctextes = $doctextes . "<li>aaaaaaaaaaaaaaaaaaa";
                                $doctexteu = $doctexteu . "<li>";

                                if ( $doc->getEstekaeu()) {
                                    $doctextes = "<a href='" . $doc->getEstekaes() . " target='_blank'>" . $doc->getKodea() . " " . $doc->getDeskribapenaes() . "</a>";
                                    $doctexteu = "<a href='" . $doc->getEstekaeu() . " target='_blank'>" . $doc->getKodea() . " " . $doc->getDeskribapenaeu() . "</a>";
                                } else {
                                    $doctextes = $doc->getKodea(). " " . $doc->getDeskribapenaes();
                                    $doctexteu = $doc->getKodea(). " " . $doc->getDeskribapenaeu();
                                }
                                $doctextes = $doctextes . "</li>";
                                $doctexteu = $doctexteu . "</li>";
                            }
                            $sql = $sql.$this->addElementua($A204AYUNTA,$idElementua,"Texto",$doctextes,$doctexteu,"PARRAFO");
                            $sql = $sql.$this->addElementuaBloque($A204AYUNTA,$idBlokea,$idElementua,$idOrdenElementua);
                            $idElementua += 1;
                            $idOrdenElementua += 1;
                        }
                    }
                    if ( $eremuak['dokumentazioatext'] ) {
                        $sql = $sql.$this->addElementua($A204AYUNTA,$idElementua,"Texto",$fitxa->getDokumentazioaes(),$fitxa->getDokumentazioaeu(),"PARRAFO");
                        $sql = $sql.$this->addElementuaBloque($A204AYUNTA,$idBlokea,$idElementua,$idOrdenElementua);
                        $idElementua += 1;
                        $idOrdenElementua += 1;
                    }
                    $idBlokea += 1;
                    $idOrden += 1;
                }
                /****** FIN DOKUMENTAZIOA *********************************************************************/

                /****** HASI DOKUMENTAZIO LAGUNGARRIA *********************************************************************/
                if ( ($eremuak['doklaguntext']) || ($eremuak['doklaguntable']) ) {
                    $sql = $sql.$this->addBloque($A204AYUNTA,$idBlokea,$labelak['dokumentazioalabeles'],$labelak['dokumentazioalabeleu']);
                    $sql = $sql.$this->addOrriaBloque( $A204AYUNTA, $idPagina, $idBlokea, $idOrden );

                    if ( $eremuak['doklaguntext'] ) {
                        $sql = $sql.$this->addElementua($A204AYUNTA,$idElementua,"Texto",$fitxa->getDoklagunes(),$fitxa->getDoklaguneu(),"PARRAFO");
                        $sql = $sql.$this->addElementuaBloque($A204AYUNTA,$idBlokea,$idElementua,$idOrdenElementua);
                        $idElementua += 1;
                        $idOrdenElementua += 1;
                    }

                    if ( $eremuak["doklaguntable"] ) {
                        if ($fitxa->doklagunak() ) {
                            $doctextes = "<ul>";
                            $doctexteu = "<ul>";
                            foreach ( $fitxa->doklagunak() as $doc ) {
                                $doctextes = $doctextes . "<li>";
                                $doctexteu = $doctexteu . "<li>";

                                if ( $doc->getEstekaeu()) {
                                    $doctextes = "<a href='" . $doc->getEstekaes() . " target='_blank'>" . $doc->getKodea() . " " . $doc->getDeskribapenaes() . "</a>";
                                    $doctexteu = "<a href='" . $doc->getEstekaeu() . " target='_blank'>" . $doc->getKodea() . " " . $doc->getDeskribapenaeu() . "</a>";
                                } else {
                                    $doctextes = $doc->getKodea(). " " . $doc->getDeskribapenaes();
                                    $doctexteu = $doc->getKodea(). " " . $doc->getDeskribapenaeu();
                                }
                                $doctextes = $doctextes . "</li>";
                                $doctexteu = $doctexteu . "</li>";
                            }
                            $sql = $sql.$this->addElementua($A204AYUNTA,$idElementua,"Texto",$doctextes,$doctexteu,"PARRAFO");
                            $sql = $sql.$this->addElementuaBloque($A204AYUNTA,$idBlokea,$idElementua,$idOrdenElementua);
                            $idElementua += 1;
                            $idOrdenElementua += 1;
                        }
                    }

                    $idBlokea += 1;
                    $idOrden += 1;
                }
                /****** FIN DOKUMENTAZIO LAGUNGARRIA *********************************************************************/

                /****** HASI KANALA *********************************************************************/
                if ( ($eremuak['kanalatext']) || ($eremuak['kanalatable']) ) {
                    $sql = $sql.$this->addBloque($A204AYUNTA,$idBlokea,$labelak['kanalalabeles'],$labelak['kanalalabeleu']);
                    $sql = $sql.$this->addOrriaBloque( $A204AYUNTA, $idPagina, $idBlokea, $idOrden );

                    if ( $eremuak["kanalatable"] ) {

                        foreach ( $kanalmotak as $k ) {
                            $aurkitua = 0;
                            $textes = "<ul>";
                            $texteu = "<ul>";

                            foreach ($fitxa->getKanalak() as $kanala) {

                                if ( $kanala == $k ) {
                                    if ($aurkitua==0) {
                                        if ($k->getIkonoa()) {
                                            $textes = $textes . "<i class='fa " . $k->getIkonoa() . " aria-hidden='true'></i>";
                                            $texteu = $texteu . "<i class='fa " . $k->getIkonoa() . " aria-hidden='true'></i>";
                                        }
                                        $textes = $textes . "<b>" . $k->getMotaes() . ":</b>";
                                        $texteu = $texteu . "<b>" . $k->getMotaeu() . ":</b>";
                                        $aurkitua = 1;
                                    }
                                    if ( $kanala->getTematikoa()) {
                                        if ($fitxa->getZerbitzua()) {
                                            $textes = $textes . "<li><a href='" .$fitxa->getZerbitzua()->getErroaes().$fitxa->getUdala()->getKodea().$fitxa->getParametroa()."' target='_blank'>" . $kanal->getIzenaes() ."</a></li>";
                                            $texteu = $texteu . "<li><a href='" .$fitxa->getZerbitzua()->getErroaeu().$fitxa->getUdala()->getKodea().$fitxa->getParametroa()."' target='_blank'>" . $kanal->getIzenaeu() ."</a></li>";
                                        }
                                    } else {
                                        if ($k->getEsteka()) {
                                            $textes = $textes."<li>";
                                            $texteu = $texteu."<li>";
                                            if ($kanala->getIzenaes()) {
                                                if ( (strpos($kanala->getEstekaes(),"@")===true) and (strpos($kanala->getEstekaeu(),"maps")==false) ) {
                                                    $textes = $textes . "<a href='mailto:" . $kanal->getEstekaes() . "'>" . $kanal->getIzenaes(). "</a><br />";
                                                    $texteu = $texteu . "<a href='mailto:" . $kanal->getEstekaeu() . "'>" . $kanal->getIzenaeu(). "</a><br />";
                                                } else {
                                                    $textes = $textes . "<a href='" . $kanal->getEstekaes() . "' target='_blank'>" . $kanal->getIzenaes(). "</a><br />";
                                                    $texteu = $texteu . "<a href='" . $kanal->getEstekaeu() . "' target='_blank'>" . $kanal->getIzenaeu(). "</a><br />";
                                                }
                                            }
                                            if ($kanala->getKalea()) {
                                                $textes = $textes . $kanala->getKalea();
                                                $texteu = $texteu . $kanala->getKalea();
                                            }
                                            if ($kanala->getKalezbkia()){
                                                $textes = $textes . $kanala->getKalezbkia();
                                                $texteu = $texteu . $kanala->getKalezbkia();
                                            }
                                            if ($kanala->getPostakodea()){
                                                $textes = $textes . $kanala->gePostakodea();
                                                $texteu = $texteu . $kanala->gePostakodea();
                                            }
                                            if ($kanala->getUdala()){
                                                $textes = $textes . $kanala->getUdala()."<br/>";
                                                $texteu = $texteu . $kanala->getUdala()."<br/>";
                                            }
                                            if ($kanala->getOrdutegia()){
                                                $textes = $textes . $kanala->getOrdutegia()."<br/>";
                                                $texteu = $texteu . $kanala->getOrdutegia()."<br/>";
                                            }
                                            if ($kanala->getTelefonoa()){
                                                $textes = $textes . $kanala->getTelefonoa()."<br/>";
                                                $texteu = $texteu . $kanala->getTelefonoa()."<br/>";
                                            }
                                            if ($kanala->getFax()){
                                                $textes = $textes . $kanala->getFax()."<br/>";
                                                $texteu = $texteu . $kanala->getFax()."<br/>";
                                            }
                                            $textes=$textes."</li>";
                                            $texteu=$texteu."</li>";
                                        } else { // if ($k->getEsteka())
                                            $textes = $textes."<li>";
                                            $texteu = $texteu."<li>";
                                            if ($kanala->getIzenaes()){
                                                $textes = $textes . $kanala->getIzenaes()."<br/>";
                                                $texteu = $texteu . $kanala->getIzenaes()."<br/>";
                                            }
                                            if ($kanala->getKalea()) {
                                                $textes = $textes . $kanala->getKalea();
                                                $texteu = $texteu . $kanala->getKalea();
                                            }
                                            if ($kanala->getKalezbkia()){
                                                $textes = $textes . $kanala->getKalezbkia();
                                                $texteu = $texteu . $kanala->getKalezbkia();
                                            }
                                            if ($kanala->getPostakodea()){
                                                $textes = $textes . $kanala->gePostakodea();
                                                $texteu = $texteu . $kanala->gePostakodea();
                                            }
                                            if ($kanala->getUdala()){
                                                $textes = $textes . $kanala->getUdala()."<br/>";
                                                $texteu = $texteu . $kanala->getUdala()."<br/>";
                                            }
                                            if ($kanala->getOrdutegia()){
                                                $textes = $textes . $kanala->getOrdutegia()."<br/>";
                                                $texteu = $texteu . $kanala->getOrdutegia()."<br/>";
                                            }
                                            if ($kanala->getTelefonoa()){
                                                $textes = $textes . $kanala->getTelefonoa()."<br/>";
                                                $texteu = $texteu . $kanala->getTelefonoa()."<br/>";
                                            }
                                            if ($kanala->getFax()){
                                                $textes = $textes . $kanala->getFax()."<br/>";
                                                $texteu = $texteu . $kanala->getFax()."<br/>";
                                            }
                                            $textes = $textes."</li>";
                                            $texteu = $texteu."</li>";
                                        }
                                    }
                                }
                            }
                            $textes = $textes."</ul>";
                            $texteu = $texteu."</ul>";
                        }
                    }
                    if ( $eremuak['kanalatext'] ) {
                        $sql = $sql.$this->addElementua($A204AYUNTA,$idElementua,"Texto",$fitxa->getKanalaes(),$fitxa->getKanalaeu(),"PARRAFO");
                        $sql = $sql.$this->addElementuaBloque($A204AYUNTA,$idBlokea,$idElementua,$idOrdenElementua);
                        $idElementua += 1;
                        $idOrdenElementua += 1;
                    }
                    $idBlokea += 1;
                    $idOrden += 1;
                }
                /****** FIN DOKUMENTAZIOA *********************************************************************/



                $idPagina += 1;
                $progress->advance();
            }


            // Fitxategia sortu
            $fs = new Filesystem();
            try {
                $fs->dumpFile( $filename, $sql );
            } catch ( IOExceptionInterface $e ) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }

            $progress->finish();
        }
    }
