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

        $A204AYUNTA = $udalKodea;
        $A204IDPAGINA = $idPagina;
        $idPagina +=1;

        $A204DENOMI = 'Home ' . $udala->getIzenaeu();
        $A204TITCAST = 'Inicio ' . $udala->getIzenaes();
        $A204TITEUSK = $udala->getIzenaeu().' Hasiera';
        $A204PUBLICADA = 1;
        $A204FECALTA = date('Ymd');
        $A204TIPO = "HOME";
        $A204IDTIPO = "USC";
        $sql="INSER INTO paginas (A204AYUNTA,A204IDPAGINA,A204DENOMI,A204TITCAST,A204TITEUSK,A204PUBLICADA,A204FECALTA,A204TIPO,A204IDTIPO)
            VALUES ($A204AYUNTA,$A204IDPAGINA, $A204DENOMI, $A204TITCAST, $A204TITEUSK, $A204PUBLICADA, $A204FECALTA, $A204TIPO, $A204IDTIPO)";


        // Fitxategia sortu
        $fs = new Filesystem();
        try {
            $fs->dumpFile($filename, $sql);
        } catch (IOExceptionInterface $e) {
            echo "An error occurred while creating your directory at ".$e->getPath();
        }
    }
}
