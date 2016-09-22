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
    protected function configure()
    {
        $this
            ->setName('api:izfe')
            ->setDescription('Zerbitzu telematikoen fitxategia sortu')
            ->addArgument('udalKodea', InputArgument::REQUIRED, 'Udal kodea, adibidez pasaiarentzat 064.');
    }


    function addOrria($A204AYUNTA,$IdPagina, $denomi, $titcast, $titeus, $publicada, $izid) {
        $A204IDPAGINA = $IdPagina;
        $A204DENOMI = "'Home " . $denomi . "'";
        $A204TITCAST = "'Inicio " . $titcast . "'";
        $A204TITEUSK = "'" . $titeus ." Hasiera'";
        $A204PUBLICADA = $publicada;
        $A204FECALTA = date('Ymd');
        $A204TIPO = "'HOME'";
        $A204IDTIPO = "'USC'";
        $sql = "INSERT INTO UDAA20401 (A204AYUNTA,A204IDPAGINA,A204DENOMI,A204TITCAST,A204TITEUSK,A204PUBLICADA,A204FECALTA,A204TIPO,A204IDTIPO)
            VALUES ($A204AYUNTA, $A204IDPAGINA, $A204DENOMI, $A204TITCAST, $A204TITEUSK, $A204PUBLICADA, $A204FECALTA, $A204TIPO, $A204IDTIPO);\n";

        return $sql;
    }

    function addBloque($A204AYUNTA, $idBlokea, $titeus, $tites) {
        $A203AYUNTA = $A204AYUNTA;
        $A203IDBLOQUE = $idBlokea;
        $A203DENOMI = "'" . $idBlokea . " Blokea'";
        $A203TITCAST = "'" . $tites . "'";
        $A203TITEUSK = "'" . $titeus . "'";
        $A203FECALTA = date('Ymd');

        $sql = "INSERT INTO UDAA20301 (A203AYUNTA,A203IDBLOQUE,A203DENOMI,A203TITCAST,A203TITEUSK,A203FECALTA)
            VALUES($A203AYUNTA, $A203IDBLOQUE, $A203DENOMI, $A203TITCAST, $A203TITEUSK, $A203FECALTA);\n";

        return $sql;
    }

    function addOrriaBloque ($A204AYUNTA, $idPagina, $idBlokea, $idOrden) {
        $A206AYUNTA = $A204AYUNTA;
        $A206IDPAGINA = $idPagina;
        $A206IDBLOQUE = $idBlokea;
        $A206ORDEN = $idOrden;
        $A206VISUAL = 1;

        $sql = "INSERT INTO UDAA20601 (A206AYUNTA,A206IDPAGINA,A206IDBLOQUE,A206ORDEN,A206VISUAL) 
                VALUES($A206AYUNTA, $A206IDPAGINA, $A206IDBLOQUE, $A206ORDEN, $A206VISUAL);\n";

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $udalKodea = $input->getArgument('udalKodea');
        $filename = "web/doc/$udalKodea/izfesql.sql";

        $em = $this->getContainer()->get( 'doctrine' )->getManager();

        $udala = $em->getRepository( 'BackendBundle:Udala' )->findOneBy(
            array (
                'kodea' => $udalKodea
            )
        );

        $output->writeln([
            '',
            '<info>===============================</info>',
            'Aukeratutako udala => ' . $udala->getIzenaeu(),
            'Sortuko den fitxategia => '.$filename,
            '<info>===============================</info>',
            '',
            ''
        ]);

        // Fitxa bat sortzen
        $fitxak = $em->getRepository( 'BackendBundle:Fitxa' )->findAll(
            array(
                'publikoa' => 1,
                'udala_id' => $udala->getId()
            )
        );


        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Datuak zuzenak dira? Horrela bada tauletako datuak ezabatuko dira.',
            array('Bai', 'Ez'),
            null
        );

        $color = $helper->ask($input, $output, $question);

        if ( $color === 'Ez' ) {
            $output->writeln([
                '',
                '<info>===============================</info>',
                'Erabiltzaileak prozesua ezeztatu du.',
                '<info>===============================</info>',
                '',
                ''
            ]);
            return;
        }


        /** CONFIGURAZIOA */
        $COUNT_FITXA = count( $fitxak );
        $idPagina=10000;
        $idBlokea=10000;
        $idOrden=1;
        $idElementua = 10000;
        $A204AYUNTA = "'" . $udalKodea . "'";

        $sql = "DELETE FROM `UDAA20401` WHERE A204AYUNTA=$A204AYUNTA;\n"; // Orriak
        $sql = $sql . "DELETE FROM `UDAA20201`; WHERE=$A204AYUNTA;\n"; // Elementuak
        $sql = $sql . "DELETE FROM `UDAT203`; WHERE=$A204AYUNTA;\n"; // Blokeak
        $sql = $sql . "DELETE FROM `UDAA20501`; WHERE=$A204AYUNTA;\n"; // Blokeak - Elementuak
        $sql = $sql . "DELETE FROM `UDAT206`; WHERE=$A204AYUNTA;\n"; // Orriak - Blokeak


        $output->writeln([ $COUNT_FITXA.' aurkitu dira.','' ]);

        $progress = new ProgressBar($output, $COUNT_FITXA);
        $progress->start();


        $query = $em->createQuery('
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', $udala->getId());
        $eremuak = $query->getSingleResult();

        $query = $em->createQuery('
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', $udala->getId());
        $labelak = $query->getSingleResult();

            foreach ($fitxak as $fitxa) {
                $izid = com_create_guid();
                $sql = $sql.$this->addOrria( $A204AYUNTA, $idPagina,$fitxa->getEspedientekodea(),$fitxa->getEspedientekodea(), $fitxa->getDeskribapenaeu(),1 );
                $sql = $sql."SET @OrriaID = LAST_INSERT_ID();\n";
                $idPagina += 1;

                if ($eremuak['helburuatext'])  {
                    $sql = $sql.$this->addBloque( $A204AYUNTA, $idBlokea, $labelak['helburualabeleu'], $labelak['helburualabeles']);
                    $idBlokea +=1;
                }

                $progress->advance();
            }



//        // Blokeak
//
//        $query = $em->createQuery('
//          SELECT f FROM BackendBundle:Familia f LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
//            WHERE u.kodea = :udala
//        ');
//        $query->setParameter('udala', $udalKodea);
//        $familiak = $query->getResult();
//
//        $idBlokea=0;
//        $idOrden=0;
//        $idElementua = 0;
//
//
//
//        foreach ($familiak as $f) {
//            $idBlokea += 1;
//            $idOrden +=1;
//            $output->writeln([
//                '',
//                'Blokeak sortzen... ' . $f->getFamiliaeu()
//            ]);
//
//
//
//            $output->writeln([
//                'Blokeak eta orriak erlazionatzen... ',
//            ]);
//
//
//
//
//            // elementuak
//            $output->writeln( 'Blokeak eta elementuak erlaziontzen...' );
//            $nOrden = 0;
//            foreach ($f->getFitxak() as $fitxa) {
//                $output->write( '.' );
//
//                $nOrden +=1;
//                $idElementua += 1;
//
//                $A202AYUNTA = "'" . $udalKodea . "'";
//                $A202IDLINEA = $idElementua;
//                $A202DENOMI = "'Enlazea " . $fitxa->getDeskribapenaes() . "'";
//                $A202TEXCAST = "'" . $fitxa->getDeskribapenaes() . "'";
//                $A202TEXEUSK = "'" . $fitxa->getDeskribapenaeu() . "'";
//                $A202LINKEXT = "";
//                $A202SERVICIO = "'PROPIA'";
//                $A202FECALTA = "";
//                $A202FECBAJA = "";
//
//                $sql = $sql . "INSERT INTO UDAA20201 (A202AYUNTA,A202IDLINEA,A202DENOMI,A202TEXCAST,A202TEXEUSK,A202SERVICIO)
//                    VALUES($A202AYUNTA, $A202IDLINEA, $A202DENOMI, $A202TEXCAST, $A202TEXEUSK, $A202SERVICIO);\n";
//
//
//                // blokeak elementuak
//                $A205AYUNTA = "'" . $udalKodea . "'";
//                $sql = $sql . "INSERT INTO UDAA20501 (A205AYUNTA,A205IDBLOQUE,A205IDLINEA,A205ORDEN)
//                    VALUES($A205AYUNTA, $idBlokea, $idElementua, $nOrden);\n";
//
//
//            }
//
//
//
//        }
//        $output->writeln( '' );
//        $output->writeln( 'Amaituta.' );
//
//
//        $idPagina +=1;



        // Fitxategia sortu
        $fs = new Filesystem();
        try {
            $fs->dumpFile($filename, $sql);
        } catch (IOExceptionInterface $e) {
            echo "An error occurred while creating your directory at ".$e->getPath();
        }

        $progress->finish();
    }
}
