<?php

namespace ApiBundle\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Zerbikat\BackendBundle\Entity\Udala;

class EzabatuCommand extends ContainerAwareCommand {

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:ezabatu')
            ->setDescription('Helmugako udaleko datuak ezabatzen ditu')
            ->addArgument('des', InputArgument::OPTIONAL, 'Helmuga udal kodea:')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $des = $input->getArgument('des');
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        if (!$des) {
            $desquestion = new Question('Helmuga udal kodea? => ', false);

            $des = $helper->ask($input, $output, $desquestion);

            if (!$des) {
                return;
            }
        }

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        /** @var Udala $desUdala */
        $desUdala = $em->getRepository('BackendBundle:Udala')->findOneBy(array('kodea' => $des,));

        $seguruQuestion = new ConfirmationQuestion(
            $desUdala->getIzenaeu().' udaleko datuak ezabatuko dira. Ziur zaude? (Y/N): ', true
        );
        if (!$helper->ask($input, $output, $seguruQuestion)) {
            $output->writeln('Agur.');

            return;
        }

        $output->write('-- Helmugako Arau Motak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Araumota','am')->where('am.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Prozedurak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Prozedura','am')->where('am.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Araudia ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Araudia','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Arrunta ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Arrunta','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Aurreikusi ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Aurreikusi','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Aurreikusi ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Barrutia','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Eraikina ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Eraikina','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Kalea ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kalea','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Sailak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Saila','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Azpi Sailak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Azpisaila','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Besteak 1 ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Besteak1','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Besteak 2 ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Besteak2','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Besteak 3 ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Besteak3','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Datuen babesa ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Datuenbabesa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Baldintzak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Baldintza','b')->where('b.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Doklagun ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Doklagun','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Dokumentu Motak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Dokumentumota','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Dokumentazioa ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Dokumentazioa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Eremuak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Eremuak','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Eremuak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Etiketa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Azpi atalak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Azpiatala','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Azpi atalen parrafoak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Azpiatalaparrafoa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Familiak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Familia','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Nork eskatu ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Norkeskatu','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Nork ebatzi ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Norkebatzi','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Kontzeptu motak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kontzeptumota','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Kontzeptuak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kontzeptua','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Kanal motak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kanalmota','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Kanalak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kanala','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Isiltasun administratiboa ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:IsiltasunAdministratiboa','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Fitxa ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Fitxa','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Fitxa-Araudia ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:FitxaAraudia','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Fitxa-Prozedura ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:FitxaProzedura','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Fitxa-Kostua ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:FitxaKostua','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');

        $output->write('-- Helmugako Fitxa-Familia ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Fitxafamilia','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
    }
}
