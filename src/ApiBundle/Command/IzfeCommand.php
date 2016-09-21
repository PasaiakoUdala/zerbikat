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
            $A204IDPAGINA = $IdPagina;
            $A204DENOMI = "'Home ".$denomi."'";
            $A204DENOMI = mb_strimwidth( $A204DENOMI, 0, 97, "..." );
            $A204TITCAST = "'Inicio ".$titcast."'";
            $A204TITEUSK = "'".$titeus." Hasiera'";
            $A204PUBLICADA = $publicada;
            $A204FECALTA = date( 'Ymd' );

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
            VALUES ($A204AYUNTA, $A204IDPAGINA, $A204DENOMI, $A204TITCAST, $A204TITEUSK, $A204PUBLICADA, $A204FECALTA, $A204TIPO, $A204IDTIPO);\n";

            return $sql;
        }

        function addBloque ( $A204AYUNTA, $idBlokea, $titeus, $tites )
        {
            $A203AYUNTA = $A204AYUNTA;
            $A203IDBLOQUE = $idBlokea;
            $A203DENOMI = "'".$idBlokea." Blokea'";
            $A203DENOMI = mb_strimwidth( $A203DENOMI, 0, 97, "..." );
            $A203TITCAST = "'".$tites."'";
            $A203TITEUSK = "'".$titeus."'";
            $A203FECALTA = date( 'Ymd' );

            $sql = "INSERT INTO UDAA20301 (A203AYUNTA,A203IDBLOQUE,A203DENOMI,A203TITCAST,A203TITEUSK,A203FECALTA)
            VALUES($A203AYUNTA, $A203IDBLOQUE, $A203DENOMI, $A203TITCAST, $A203TITEUSK, $A203FECALTA);\n";

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
            $A202AYUNTA = $A204AYUNTA;
            $A202IDLINEA = $idElementua;
            $A202DENOMI = "'".$denomi."'";
            $A202DENOMI = mb_strimwidth( $A202DENOMI, 0, 97, "..." );
            $A202TEXCAST = "'".$titcast."'";
            $A202TEXEUSK = "'".$titeus."'";
            $A202SERVICIO = "'".$tipo."'";
            $A202LINKEXT = $link;
            if ( $tipo == "PROPIA" ) {
                $A202LINKEXT = "'".$link."'";
            }
            $A202FECALTA = date( 'Ymd' );

            $sql = "INSERT INTO UDAA20201 (A202AYUNTA, A202IDLINEA, A202DENOMI, A202TEXCAST, A202TEXEUSK, A202LINKEXT, A202SERVICIO,A202FECALTA)
                               VALUES($A202AYUNTA, $A202IDLINEA, $A202DENOMI, $A202TEXCAST, $A202TEXEUSK, $A202LINKEXT, $A202SERVICIO, $A202FECALTA);\n";

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

            $sql = "DELETE FROM `UDAA20401` WHERE A204AYUNTA=$A204AYUNTA;\n"; // Orriak
            $sql = $sql."DELETE FROM `UDAA20201` WHERE A202AYUNTA=$A204AYUNTA;\n"; // Elementuak
            $sql = $sql."DELETE FROM `UDAA20301` WHERE A203AYUNTA=$A204AYUNTA;\n"; // Blokeak
            $sql = $sql."DELETE FROM `UDAA20501` WHERE A205AYUNTA=$A204AYUNTA;\n"; // Blokeak - Elementuak
            $sql = $sql."DELETE FROM `UDAA20601` WHERE A206AYUNTA=$A204AYUNTA;\n"; // Orriak - Blokeak


            $output->writeln( [$COUNT_FITXA.' aurkitu dira.', ''] );

            $progress = new ProgressBar( $output, $COUNT_FITXA );
            $progress->start();


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

            // Home-a sortu
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

            foreach ( $fitxak as $fitxa ) {
                $sql = $sql.$this->addOrria(
                        $A204AYUNTA,
                        $idPagina,
                        $fitxa->getEspedientekodea(),
                        $fitxa->getEspedientekodea(),
                        $fitxa->getDeskribapenaeu(),
                        1,
                        "UXX"
                    );
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

                if ( $eremuak['helburuatext'] ) {
                    $sql = $sql.$this->addBloque(
                            $A204AYUNTA,
                            $idBlokea,
                            $labelak['helburualabeleu'],
                            $labelak['helburualabeles']
                        );
                    $sql = $sql.$this->addOrriaBloque( $A204AYUNTA, $idPagina, $idBlokea, $idOrden );
                    $sql = $sql.$this->addElementua(
                            $A204AYUNTA,
                            $idElementua,
                            "Texto",
                            $fitxa->getHelburuaeu(),
                            $fitxa->getHelburuaes(),
                            "PARRAFO"
                        );
                    $sql = $sql.$this->addElementuaBloque( $A204AYUNTA, $idBlokea, $idElementua, $idOrdenElementua );
                    $idBlokea += 1;
                    $idOrden += 1;
                    $idOrdenElementua += 1;
                    $idElementua += 1;
                }

                if ( ($eremuak['norkeskatutext']) || ($eremuak['norkeskatutable']) ) {
                    $sql = $sql.$this->addBloque(
                            $A204AYUNTA,
                            $idBlokea,
                            $labelak['norkeskatulabeleu'],
                            $labelak['norkeskatulabeles']
                        );
                    $sql = $sql.$this->addOrriaBloque( $A204AYUNTA, $idPagina, $idBlokea, $idOrden );

                    if ( $eremuak['norkeskatutext'] ) {
                        $sql = $sql.$this->addElementua(
                                $A204AYUNTA,
                                $idElementua,
                                "Texto",
                                $fitxa->getNorkeu(),
                                $fitxa->getNorkes(),
                                "PARRAFO"
                            );
                        $sql = $sql.$this->addElementuaBloque(
                                $A204AYUNTA,
                                $idBlokea,
                                $idElementua,
                                $idOrdenElementua
                            );
                        $idElementua += 1;
                        $idOrdenElementua += 1;
                    } else {
                        if ( $eremuak["norkeskatutable"] ) {
                            foreach ( $fitxak->getNorkeskatuak() as $nork ) {
                                $sql = $sql.$this->addElementua(
                                        $A204AYUNTA,
                                        $idElementua,
                                        "Texto",
                                        $fitxa->getNorkeu(),
                                        $fitxa->getNorkes(),
                                        "PARRAFO"
                                    );
                                $sql = $sql.$this->addElementuaBloque(
                                        $A204AYUNTA,
                                        $idBlokea,
                                        $idElementua,
                                        $idOrdenElementua
                                    );
                                $idElementua += 1;
                                $idOrdenElementua += 1;
                            }
                        }
                    }


                    $idBlokea += 1;
                    $idOrden += 1;

                }

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
