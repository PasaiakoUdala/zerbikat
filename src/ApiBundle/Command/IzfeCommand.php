<?php

namespace ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Zerbikat\BackendBundle\Entity\Udala;

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

        $idPagina=1;
        $A204AYUNTA = "'" . $udalKodea . "'";
        $A204IDPAGINA = $idPagina;


        $A204DENOMI = "'Home " . $udala->getIzenaeu() . "'";
        $A204TITCAST = "'Inicio " . $udala->getIzenaes() . "'";
        $A204TITEUSK = "'" . $udala->getIzenaeu()." Hasiera'";
        $A204PUBLICADA = 1;
        $A204FECALTA = date('Ymd');
        $A204TIPO = "'HOME'";
        $A204IDTIPO = "'USC'";
        $sql = "TRUNCATE TABLE `UDAT204`;\n"; // Orriak
        $sql = $sql . "INSERT INTO UDAT204 (A204AYUNTA,A204IDPAGINA,A204DENOMI,A204TITCAST,A204TITEUSK,A204PUBLICADA,A204FECALTA,A204TIPO,A204IDTIPO)
            VALUES ($A204AYUNTA,$A204IDPAGINA, $A204DENOMI, $A204TITCAST, $A204TITEUSK, $A204PUBLICADA, $A204FECALTA, $A204TIPO, $A204IDTIPO);\n";


        // Blokeak

        $query = $em->createQuery('
          SELECT f FROM BackendBundle:Familia f LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
            WHERE u.kodea = :udala
        ');
        $query->setParameter('udala', $udalKodea);
        $familiak = $query->getResult();

        $idBlokea=0;
        $idOrden=0;
        $idElementua = 0;
        $sql = $sql . "TRUNCATE TABLE `UDAT203`;\n"; // Blokeak
        $sql = $sql . "TRUNCATE TABLE `UDAT206`;\n"; // Orriak - Blokeak
        $sql = $sql . "TRUNCATE TABLE `UDAT202`;\n"; // Orriak - Blokeak

        foreach ($familiak as $f) {
            $idBlokea += 1;
            $idOrden +=1;
            $output->writeln([
                '',
                'Blokeak sortzen... ' . $f->getFamiliaeu()
            ]);

            $A203AYUNTA = "'" . $udalKodea . "'";
            $A203IDBLOQUE = $idBlokea;
            $A203DENOMI = "'" . $idBlokea . " Blokea'";
            $A203TITCAST = "'" . $f->getFamiliaes() . "'";
            $A203TITEUSK = "'" . $f->getFamiliaeu() . "'";
            $A203FECALTA = date('Ymd');

            // Blokeak
            $sql = $sql . "INSERT INTO UDAT203 (A203AYUNTA,A203IDBLOQUE,A203DENOMI,A203TITCAST,A203TITEUSK,A203FECALTA)
                VALUES($A203AYUNTA,$A203IDBLOQUE,$A203DENOMI,$A203TITCAST,$A203TITEUSK,$A203FECALTA);\n";

            $output->writeln([
                'Blokeak eta orriak erlazionatzen... ',
                ''
            ]);

            $A206AYUNTA = "'" . $udalKodea . "'";
            $A206IDPAGINA = $idPagina;
            $A206IDBLOQUE = $idBlokea;
            $A206ORDEN = $idOrden;
            $A206VISUAL = 1;

            // Orriak - Blokeak
            $sql = $sql . "INSERT INTO UDAT206 (A206AYUNTA,A206IDPAGINA,A206IDBLOQUE,A206ORDEN,A206VISUAL)
                VALUES($A206AYUNTA,$A206IDPAGINA,$A206IDBLOQUE,$A206ORDEN,$A206VISUAL);\n";


            // elementuak
            foreach ($f->getFitxak() as $fitxa) {
                $output->writeln( $fitxa->getDeskribapenaeu() );

                $idElementua += 1;

                $A202AYUNTA = "'" . $udalKodea . "'";
                $A202IDLINEA = $idElementua;
                $A202DENOMI = "'Enlazea " . $fitxa->getDeskribapenaes() . "'";
                $A202TEXCAST = "'" . $fitxa->getDeskribapenaes() . "'";
                $A202TEXEUSK = "'" . $fitxa->getDeskribapenaeu() . "'";
                $A202LINKEXT = "";
                $A202SERVICIO = "'PROPIA'";
                $A202FECALTA = "";
                $A202FECBAJA = "";

                $sql = $sql . "INSERT INTO UDAT202 (A202AYUNTA,A202IDLINEA,A202DENOMI,A202TEXCAST,A202TEXEUSK,A202SERVICIO)
                    VALUES($A202AYUNTA,$A202IDLINEA,$A202DENOMI,$A202TEXCAST,$A202TEXEUSK,$A202SERVICIO);\n";
            }
        }




        $idPagina +=1;



        // Fitxategia sortu
        $fs = new Filesystem();
        try {
            $fs->dumpFile($filename, $sql);
        } catch (IOExceptionInterface $e) {
            echo "An error occurred while creating your directory at ".$e->getPath();
        }
    }
}
