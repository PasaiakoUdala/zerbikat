<?php

namespace ApiBundle\Command;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Zerbikat\BackendBundle\Entity\Araudia;
use Zerbikat\BackendBundle\Entity\Araumota;
use Zerbikat\BackendBundle\Entity\Arrunta;
use Zerbikat\BackendBundle\Entity\Aurreikusi;
use Zerbikat\BackendBundle\Entity\Azpiatala;
use Zerbikat\BackendBundle\Entity\Azpiatalaparrafoa;
use Zerbikat\BackendBundle\Entity\Azpisaila;
use Zerbikat\BackendBundle\Entity\Baldintza;
use Zerbikat\BackendBundle\Entity\Barrutia;
use Zerbikat\BackendBundle\Entity\Besteak1;
use Zerbikat\BackendBundle\Entity\Besteak2;
use Zerbikat\BackendBundle\Entity\Besteak3;
use Zerbikat\BackendBundle\Entity\Datuenbabesa;
use Zerbikat\BackendBundle\Entity\Doklagun;
use Zerbikat\BackendBundle\Entity\Dokumentazioa;
use Zerbikat\BackendBundle\Entity\Dokumentumota;
use Zerbikat\BackendBundle\Entity\Eraikina;
use Zerbikat\BackendBundle\Entity\Eremuak;
use Zerbikat\BackendBundle\Entity\Espedientekudeaketa;
use Zerbikat\BackendBundle\Entity\Etiketa;
use Zerbikat\BackendBundle\Entity\Familia;
use Zerbikat\BackendBundle\Entity\Fitxa;
use Zerbikat\BackendBundle\Entity\FitxaAraudia;
use Zerbikat\BackendBundle\Entity\FitxaKostua;
use Zerbikat\BackendBundle\Entity\FitxaProzedura;
use Zerbikat\BackendBundle\Entity\IsiltasunAdministratiboa;
use Zerbikat\BackendBundle\Entity\Kalea;
use Zerbikat\BackendBundle\Entity\Kanala;
use Zerbikat\BackendBundle\Entity\Kanalmota;
use Zerbikat\BackendBundle\Entity\Kontzeptua;
use Zerbikat\BackendBundle\Entity\Kontzeptumota;
use Zerbikat\BackendBundle\Entity\Norkebatzi;
use Zerbikat\BackendBundle\Entity\Norkeskatu;
use Zerbikat\BackendBundle\Entity\Prozedura;
use Zerbikat\BackendBundle\Entity\Saila;
use Zerbikat\BackendBundle\Entity\Udala;
use Zerbikat\BackendBundle\Entity\Zerbitzua;

class CopyCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:copy')
            ->setDescription('Udal bateko datu basea beste udal batera kopiatzeko agindua')
            ->addArgument('ori', InputArgument::OPTIONAL, 'Abiapuntu udal kodea:')
            ->addArgument('des', InputArgument::OPTIONAL, 'Helmuga udal kodea:');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ori = $input->getArgument('ori');
        $des = $input->getArgument('des');
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        if ((!$ori) || (!$des)) {
            $oriquestion = new Question('Abiapuntu udal kodea? => ', false);
            $desquestion = new Question('Helmuga udal kodea? => ', false);

            $ori = $helper->ask($input, $output, $oriquestion);
            $des = $helper->ask($input, $output, $desquestion);

            if (!$ori) {
                return;
            }
            if (!$des) {
                return;
            }
        }


        $em = $this->getContainer()->get('doctrine')->getManager();
        /** @var Udala $oriUdala */
        $oriUdala = $em->getRepository('BackendBundle:Udala')->findOneBy(array('kodea' => $ori,));
        /** @var Udala $desUdala */
        $desUdala = $em->getRepository('BackendBundle:Udala')->findOneBy(array('kodea' => $des,));

        $seguruQuestion = new ConfirmationQuestion(
            $oriUdala->getIzenaeu().' udaleko datuak '.$desUdala->getIzenaeu().' udalean kopiatuko dira. Ziur zaude? OHARRA: Helburuko datuak ezabatu egingo dira lehenbizi. (Y/N): ', true
        );
        if (!$helper->ask($input, $output, $seguruQuestion)) {
            $output->writeln('Agur.');

            return;
        }

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ARAUMOTA ******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Arau Motak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Araumota','am')->where('am.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Arau Mota kopiatzen...');
        $oriArauMota = $em->getRepository('BackendBundle:Araumota')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Araumota $m */
        foreach ($oriArauMota as $m) {
            $arauMota = new Araumota();
            $arauMota->setKodea($m->getKodea());
            $arauMota->setMotaes($m->getMotaes());
            $arauMota->setMotaeu($m->getMotaeu());
            $arauMota->setUdala($desUdala);
            $arauMota->setOrigenid($m->getId());
            $em->persist($arauMota);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ARAUDIA *******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Araudia ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Araudia','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Araudia kopiatzen...');
        $oriAraudia = $em->getRepository('BackendBundle:Araudia')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Araudia $a */
        foreach ($oriAraudia as $a) {
            /** @var Araudia $araudia */
            $araudia = new Araudia();
            $araudia->setArauaes($a->getArauaes());
            $araudia->setArauaeu($a->getArauaeu());
            $araudia->setAraumota($a->getAraumota());
            $araudia->setEstekaes($a->getEstekaes());
            $araudia->setEstekaeu($a->getEstekaes());
            $araudia->setOrigenid($a->getId());
            $araudia->setUdala($desUdala);
            /** @var Araumota $araumota */
            $araumota = $em->getRepository('BackendBundle:Araumota')->findOneBy(array('origenid' => $a->getAraumota()->getId()));
            $araudia->setAraumota($araumota);
            $em->persist($araudia);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ARRUNTA *******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Arrunta ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Arrunta','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Arrunta kopiatzen...');
        $oriArrunta = $em->getRepository('BackendBundle:Arrunta')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Arrunta $a */
        foreach ($oriArrunta as $a) {
            $arrunta = new Arrunta();
            $arrunta->setUdala($desUdala);
            $arrunta->setEpeaes($a->getEpeaes());
            $arrunta->setEpeaeu($a->getEpeaeu());
            $arrunta->setOrigenid($a->getId());
            $em->persist($arrunta);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** AURREIKUSI*****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Aurreikusi ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Aurreikusi','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Aurreikusi kopiatzen...');
        $oriAurreikusi = $em->getRepository('BackendBundle:Aurreikusi')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Arrunta $a */
        foreach ($oriAurreikusi as $a) {
            /** @var Aurreikusi $aurreikusi */
            $aurreikusi = new Aurreikusi();
            $aurreikusi->setEpeaeu($a->getEpeaeu());
            $aurreikusi->setEpeaes($a->getEpeaes());
            $aurreikusi->setUdala($desUdala);
            $aurreikusi->setOrigenid($a->getId());
            $em->persist($aurreikusi);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BARRUTIA*******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Aurreikusi ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Barrutia','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Barrutia kopiatzen...');
        $oriBarrutia = $em->getRepository('BackendBundle:Barrutia')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Barrutia $a */
        foreach ($oriBarrutia as $a) {
            /** @var Barrutia $barrutia */
            $barrutia = new Barrutia();
            $barrutia->setUdala($desUdala);
            $barrutia->setIzena($a->getIzena());
            $barrutia->setOrigenid($a->getId());
            $em->persist($barrutia);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ERAIKINA ******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Eraikina ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Eraikina','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Eraikina kopiatzen...');
        $oriEraikina = $em->getRepository('BackendBundle:Eraikina')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Eraikina $a */
        foreach ($oriEraikina as $a) {
            $eraikina = new Eraikina();
            $eraikina->setIzena($a->getIzena());
            $eraikina->setUdala($desUdala);
            $eraikina->setLatitudea($a->getLatitudea());
            $eraikina->setLongitudea($a->getLongitudea());
            $eraikina->setOrigenid($a->getId());
            $em->persist($eraikina);

        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** Kalea ******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Kalea ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kalea','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Kalea kopiatzen...');
        $oriKalea= $em->getRepository('BackendBundle:Kalea')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Kalea $a */
        foreach ($oriKalea as $a) {
            $kalea = new Kalea();
            $kalea->setUdala($desUdala);
            $kalea->setIzena($a->getIzena());
            $barrutia = $em->getRepository('BackendBundle:Barrutia')->findOneBy(array('origenid' => $a->getBarrutia()->getId()));
            $kalea->setBarrutia($barrutia);
            $kalea->setGoogle($a->getGoogle());
            $kalea->setOrigenid($a->getId());
            $em->persist($kalea);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** SAILA *********************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Sailak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Saila','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Saila kopiatzen...');
        $oriSaila= $em->getRepository('BackendBundle:Saila')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Saila $a */
        foreach ($oriSaila as $a) {
            $saila = new Saila();
            $saila->setUdala($desUdala);
            $saila->setKodea($a->getKodea());
            $saila->setArduraduna($a->getArduraduna());
            $saila->setSailaes($a->getSailaes());
            $saila->setSailaeu($a->getSailaeu());
            $saila->setOrigenid($a->getId());
            $em->persist($saila);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** AZPISAILA *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Azpi Sailak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Azpisaila','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Azpisaila kopiatzen...');
        $oriAzpisaila= $em->getRepository('BackendBundle:Azpisaila')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Azpisaila $a */
        foreach ($oriAzpisaila as $a) {
            $azpisaila = new Azpisaila();
            $azpisaila->setArduraduna($a->getArduraduna());
            $azpisaila->setKodea($a->getKodea());
            $azpisaila->setUdala($desUdala);
            $azpisaila->setArduradunahaz($a->getArduradunahaz());
            $azpisaila->setAzpisailaes($a->getAzpisailaes());
            $azpisaila->setAzpisailaeu($a->getAzpisailaeu());
            $azpisaila->setEmail($a->getEmail());
            $azpisaila->setFax($a->getFax());
            $azpisaila->setHizkia($a->getHizkia());
            $azpisaila->setKaleZbkia($a->getKaleZbkia());
            $azpisaila->setOrdutegia($a->getOrdutegia());
            $azpisaila->setTelefonoa($a->getTelefonoa());
            /** @var Saila $_saila */
            $_saila = $em->getRepository('BackendBundle:Saila')->findOneBy(array('origenid' => $a->getSaila()->getId()));
            $azpisaila->setSaila($_saila);
            if ($a->getBarrutia()) {
                /** @var Barrutia $_barrutia */
                $_barrutia = $em->getRepository('BackendBundle:Barrutia')->findOneBy(array('origenid' => $a->getBarrutia()->getId()));
                $azpisaila->setBarrutia($_barrutia);
            }
            if ($a->getEraikina()){
                /** @var Eraikina $_eraikina */
                $_eraikina = $em->getRepository('BackendBundle:Eraikina')->findOneBy(array('origenid' => $a->getEraikina()->getId()));
                $azpisaila->setEraikina($_eraikina);
            }
            if ($a->getKalea()) {
                /** @var Kalea $_kalea */
                $_kalea = $em->getRepository('BackendBundle:Kalea')->findOneBy(array('origenid' => $a->getKalea()->getId()));
                $azpisaila->setKalea($_kalea);
            }
            $azpisaila->setOrigenid($a->getId());
            $em->persist($azpisaila);

        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BESTEAK1*******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Besteak 1 ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Besteak1','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Besteak1 kopiatzen...');
        $oriBesteak1= $em->getRepository('BackendBundle:Besteak1')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Besteak1 $a */
        foreach ($oriBesteak1 as $a) {
            /** @var Besteak1 $besteak1 */
            $besteak1 = new Besteak1();
            $besteak1->setOrigenid($a->getId());
            $besteak1->setIzenburuaes($a->getIzenburuaes());
            $besteak1->setIzenburuaeu($a->getIzenburuaeu());
            $besteak1->setEstekaes($a->getEstekaes());
            $besteak1->setEstekaeu($a->getEstekaeu());
            $besteak1->setKodea($a->getKodea());
            $besteak1->setUdala($desUdala);
            $em->persist($besteak1);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BESTEAK2 ******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Besteak 2 ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Besteak2','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Besteak2 kopiatzen...');
        $oriBesteak2= $em->getRepository('BackendBundle:Besteak2')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Besteak2 $a */
        foreach ($oriBesteak2 as $a) {
            /** @var Besteak2 $besteak1 */
            $besteak2 = new Besteak2();
            $besteak2->setOrigenid($a->getId());
            $besteak2->setIzenburuaes($a->getIzenburuaes());
            $besteak2->setIzenburuaeu($a->getIzenburuaeu());
            $besteak2->setEstekaes($a->getEstekaes());
            $besteak2->setEstekaeu($a->getEstekaeu());
            $besteak2->setKodea($a->getKodea());
            $besteak2->setUdala($desUdala);
            $em->persist($besteak2);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BESTEAK 3*******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Besteak 3 ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Besteak3','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Besteak3 kopiatzen...');
        $oriBesteak3= $em->getRepository('BackendBundle:Besteak3')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Besteak3 $a */
        foreach ($oriBesteak3 as $a) {
            /** @var Besteak3 $besteak1 */
            $besteak3 = new Besteak3();
            $besteak3->setOrigenid($a->getId());
            $besteak3->setIzenburuaes($a->getIzenburuaes());
            $besteak3->setIzenburuaeu($a->getIzenburuaeu());
            $besteak3->setEstekaes($a->getEstekaes());
            $besteak3->setEstekaeu($a->getEstekaeu());
            $besteak3->setKodea($a->getKodea());
            $besteak3->setUdala($desUdala);
            $em->persist($besteak3);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** DATUEN BABESA *************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Datuen babesa ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Datuenbabesa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Datuen babesa kopiatzen...');
        $oriDatuenBabesa = $em->getRepository('BackendBundle:Datuenbabesa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Datuenbabesa $d */
        foreach ($oriDatuenBabesa as $d) {
            $datu = new Datuenbabesa();
            $datu->setOrigenid($d->getId());
            $datu->setUdala($desUdala);
            $datu->setKodea($d->getKodea());
            $datu->setIzenaes($d->getIzenaes());
            $datu->setIzenaeu($d->getIzenaeu());
            $datu->setLagapenakes($d->getLagapenakes());
            $datu->setLagapenakeu($d->getLagapenakeu());
            $datu->setMaila($d->getMaila());
            $datu->setXedeaes($d->getXedeaes());
            $datu->setXedeaeu($d->getXedeaeu());
            $em->persist($datu);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ESPEDIENTE KUDEATZAILEA *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/

        /* EZ DA BEHAR!! */


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ZERBITZUA *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/

        /* EZ DA BEHAR!! */


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BALDINTZA *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Baldintzak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Baldintza','b')->where('b.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Baldintza kopiatzen...');
        $oriBaldintza = $em->getRepository('BackendBundle:Baldintza')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Baldintza $b */
        foreach ($oriBaldintza as $b) {
            $bal = new Baldintza();
            $bal->setOrigenid($b->getId());
            $bal->setUdala($desUdala);
            $bal->setBaldintzaes($b->getBaldintzaes());
            $bal->setBaldintzaeu($b->getBaldintzaeu());
            $em->persist($bal);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** DOKLAGUN *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Doklagun ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Doklagun','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Doklagun kopiatzen...');
        $oriDokLagun = $em->getRepository('BackendBundle:Doklagun')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Doklagun $d */
        foreach ($oriDokLagun as $d) {
            $dok = new Doklagun();
            $dok->setUdala($desUdala);
            $dok->setOrigenid($d->getId());
            $dok->setKodea($d->getKodea());
            $dok->setDeskribapenaes($d->getDeskribapenaes());
            $dok->setDeskribapenaeu($d->getDeskribapenaeu());
            $dok->setEstekaes($d->getEstekaes());
            $dok->setEstekaeu($d->getEstekaeu());
            $em->persist($dok);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** DOKUMENTO MOTA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Dokumentu Motak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Dokumentumota','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Dokumentu motak kopiatzen...');
        $oriDokMota = $em->getRepository('BackendBundle:Dokumentumota')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Dokumentumota $d */
        foreach ($oriDokLagun as $d) {
            $dokm = new Dokumentumota();
            $dokm->setKodea($d->getKodea());
            $dokm->setOrigenid($d->getId());
            $dokm->setUdala($desUdala);
            $dokm->setMotaes($d->getMotaes());
            $dokm->setMotaeu($d->getMotaeu());
            $em->persist($dokm);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** DOKUMENTAZIOA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Dokumentazioa ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Dokumentazioa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Dokumentazioa kopiatzen...');
        $oriDokumentazioa = $em->getRepository('BackendBundle:Dokumentazioa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Dokumentazioa $d */
        foreach ($oriDokumentazioa as $d) {
            $do = new Dokumentazioa();
            $do->setUdala($desUdala);
            $do->setOrigenid($d->getId());
            $do->setKodea($d->getKodea());
            $do->setEstekaeu($d->getEstekaeu());
            $do->setEstekaes($d->getEstekaes());
            $do->setDeskribapenaeu($d->getDeskribapenaeu());
            $do->setDeskribapenaes($d->getDeskribapenaes());
            if  ($d->getDokumentumota()) {
                /** @var Dokumentumota $_dokmota */
                $_dokmota= $em->getRepository('BackendBundle:Dokumentumota')->findOneBy(
                    array(
                        'origenid' => $d->getDokumentumota()->getId(),
                    )
                );
                $do->setDokumentumota($_dokmota);
            }
            $em->persist($do);

        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** EREMUA  ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Eremuak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Eremuak','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Eremuak kopiatzen...');
        $oriEremua = $em->getRepository('BackendBundle:Eremuak')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Eremuak $e */
        foreach ($oriEremua as $e) {
            $ere = new Eremuak();
            $ere->setOrigenid($e->getId());
            $ere->setUdala($desUdala);
            $ere->setAraudialabeles($e->getAraudialabeles());
            $ere->setAraudialabeleu($e->getAraudialabeleu());
            $ere->setAraudiatable($e->getAraudiatable());
            $ere->setAraudiatext($e->getAraudiatext());
            $ere->setArduraaitorpena($e->getArduraaitorpena());
            $ere->setArduraaitorpenalabeles($e->getArduraaitorpenalabeles());
            $ere->setArduraaitorpenalabeleu($e->getArduraaitorpenalabeleu());
            $ere->setArrunta($e->getArrunta());
            $ere->setArruntalabeles($e->getArruntalabeles());
            $ere->setArruntalabeleu($e->getArruntalabeleu());
            $ere->setAurreikusi($e->getAurreikusi());
            $ere->setAurreikusilabeles($e->getAurreikusilabeles());
            $ere->setAurreikusilabeleu($e->getAurreikusilabeleu());
            $ere->setAzpisailalabeles($e->getAzpisailalabeles());
            $ere->setAzpisailalabeleu($e->getAzpisailalabeleu());
            $ere->setAzpisailatable($e->getAzpisailatable());
            $ere->setBesteak1labeles($e->getBesteak1labeles());
            $ere->setBesteak1labeleu($e->getBesteak1labeleu());
            $ere->setBesteak1table($e->getBesteak1table());
            $ere->setBesteak1text($e->getBesteak1text());
            $ere->setBesteak2labeles($e->getBesteak2labeles());
            $ere->setBesteak2labeleu($e->getBesteak2labeleu());
            $ere->setBesteak2table($e->getBesteak2table());
            $ere->setBesteak2text($e->getBesteak2text());
            $ere->setBesteak3labeles($e->getBesteak3labeles());
            $ere->setBesteak3labeleu($e->getBesteak3labeleu());
            $ere->setBesteak3table($e->getBesteak3table());
            $ere->setBesteak3text($e->getBesteak3text());
            $ere->setDatuenbabesalabeles($e->getDatuenbabesalabeles());
            $ere->setDatuenbabesalabeleu($e->getDatuenbabesalabeleu());
            $ere->setDatuenbabesatable($e->getDatuenbabesatable());
            $ere->setDatuenbabesatext($e->getDatuenbabesatext());
            $ere->setDoanlabeles($e->getDoanlabeles());
            $ere->setDoanlabeleu($e->getDoanlabeleu());
            $ere->setDoklagunlabeles($e->getDoklagunlabeles());
            $ere->setDoklagunlabeleu($e->getDoklagunlabeleu());
            $ere->setDoklaguntable($e->getDoklaguntable());
            $ere->setDoklaguntext($e->getDoklaguntext());
            $ere->setDoklagunlabeleu($e->getDoklagunlabeleu());
            $ere->setDokumentazioalabeles($e->getDokumentazioalabeles());
            $ere->setDokumentazioalabeleu($e->getDokumentazioalabeleu());
            $ere->setDokumentazioatable($e->getDokumentazioatable());
            $ere->setDokumentazioatext($e->getDokumentazioatext());
            $ere->setEbazpensinpli($e->getEbazpensinpli());
            $ere->setEbazpensinplilabeles($e->getEbazpensinplilabeles());
            $ere->setEbazpensinplilabeleu($e->getEbazpensinplilabeleu());
            $ere->setEpealabeles($e->getEpealabeles());
            $ere->setEpealabeleu($e->getEpealabeleu());
            $ere->setHelburualabeles($e->getHelburualabeles());
            $ere->setHelburualabeleu($e->getHelburualabeleu());
            $ere->setHelburuatext($e->getHelburuatext());
            $ere->setIsiltasunadmin($e->getIsiltasunadmin());
            $ere->setIsiltasunadminlabeles($e->getIsiltasunadminlabeles());
            $ere->setIsiltasunadminlabeleu($e->getIsiltasunadminlabeleu());
            $ere->setKanalalabeles($e->getKanalalabeles());
            $ere->setKanalalabeleu($e->getKanalalabeleu());
            $ere->setKanalatable($e->getKanalatable());
            $ere->setKanalatext($e->getKanalatext());
            $ere->setKostualabeles($e->getKostualabeles());
            $ere->setKostualabeleu($e->getKostualabeleu());
            $ere->setKostuatable($e->getKostuatable());
            $ere->setKostuatext($e->getKostuatext());
            $ere->setNorkebatzilabeles($e->getNorkebatzilabeles());
            $ere->setNorkebatzilabeleu($e->getNorkebatzilabeleu());
            $ere->setNorkebatzitable($e->getNorkebatzitable());
            $ere->setNorkebatzitext($e->getNorkebatzitext());
            $ere->setNorkeskatulabeles($e->getNorkeskatulabeles());
            $ere->setNorkeskatulabeleu($e->getNorkeskatulabeleu());
            $ere->setNorkeskatutable($e->getNorkeskatutable());
            $ere->setNorkeskatutext($e->getNorkeskatutext());
            $ere->setOharraklabeles($e->getOharraklabeles());
            $ere->setOharraklabeleu($e->getOharraklabeleu());
            $ere->setOharraktext($e->getOharraktext());
            $ere->setProzeduralabeles($e->getProzeduralabeles());
            $ere->setProzeduralabeleu($e->getProzeduralabeleu());
            $ere->setProzeduratable($e->getProzeduratable());
            $ere->setProzeduratext($e->getProzeduratext());
            $em->persist($ere);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ETIKETA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Eremuak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Etiketa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Etiketak kopiatzen...');
        $oriEtiketa = $em->getRepository('BackendBundle:Etiketa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Etiketa $e */
        foreach ($oriEtiketa as $e) {
            $eti = new Etiketa();
            $eti->setUdala($desUdala);
            $eti->setOrigenid($e->getId());
            $eti->setEtiketaes($e->getEtiketaes());
            $eti->setEtiketaeu($e->getEtiketaeu());
            $em->persist($eti);

        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** AZPI ATALA ****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Azpi atalak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Azpiatala','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Azpiatalak kopiatzen...');
        $oriAzpiAtala = $em->getRepository('BackendBundle:Azpiatala')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Azpiatala $a */
        foreach ($oriAzpiAtala as $a) {
            $az = new Azpiatala();
            $az->setOrigenid($a->getId());
            $az->setUdala($desUdala);
            $az->setKodea($a->getKodea());
            $az->setIzenburuaeu($a->getIzenburuaeu());
            $az->setIzenburuaes($a->getIzenburuaes());
            $em->persist($az);

        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** AZPIATALA PARRAFOA ********************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Azpi atalen parrafoak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Azpiatalaparrafoa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Azpi atal parrafoak kopiatzen...');
        $oriAzpiAtalaParrafoa = $em->getRepository('BackendBundle:Azpiatalaparrafoa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Azpiatalaparrafoa $a */
        foreach ($oriAzpiAtalaParrafoa as $a) {
            $az = new Azpiatalaparrafoa();
            $az->setUdala($desUdala);
            $az->setOrigenid($a->getId());
            if ($a->getAzpiatala()) {
                /** @var Azpiatala $_azpi_atala */
                $_azpi_atala= $em->getRepository('BackendBundle:Azpiatala')->findOneBy(
                    array(
                        'origenid' => $a->getAzpiatala()->getId(),
                    )
                );
                $az->setAzpiatala($_azpi_atala);
            }
            $az->setOrdena($a->getOrdena());
            $az->setTestuaes($a->getTestuaes());
            $az->setTestuaeu($a->getTestuaeu());
            $em->persist($az);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** FAMILIA *******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Familiak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Familia','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Familiak kopiatzen...');
        $oriFamilia= $em->getRepository('BackendBundle:Familia')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Familia $f */
        foreach ($oriFamilia as $f) {
            $fam = new Familia();
            $fam->setOrdena($f->getOrdena());
            $fam->setOrigenid($f->getId());
            $fam->setUdala($desUdala);
            $fam->setDeskribapenaes($f->getDeskribapenaes());
            $fam->setDeskribapenaeu($f->getDeskribapenaeu());
            $fam->setFamiliaes($f->getFamiliaes());
            $fam->setFamiliaeu($f->getFamiliaeu());
            if ($f->getParent()) {
                /** @var Familia $_parent */
                $_parent = $em->getRepository('BackendBundle:Familia')->findOneBy(
                    array(
                        'origenid' => $f->getParent()->getId(),
                    )
                );
                $fam->setParent($_parent);
            }
            $em->persist($fam);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** NORK ESKATU****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Nork eskatu ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Norkeskatu','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Nork eskatu kopiatzen...');
        $oriNorkEskatu= $em->getRepository('BackendBundle:Norkeskatu')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Norkeskatu $n */
        foreach ($oriNorkEskatu as $n) {
            $nork = new Norkeskatu();
            $nork->setUdala($desUdala);
            $nork->setOrigenid($n->getId());
            $nork->setNorkes($n->getNorkes());
            $nork->setNorkeu($n->getNorkeu());
            $em->persist($nork);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** NORK EBATZI****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Nork ebatzi ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Norkebatzi','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Nork ebatzi kopiatzen...');
        $oriNorkEbatzi = $em->getRepository('BackendBundle:Norkebatzi')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Norkebatzi $n */
        foreach ($oriNorkEbatzi as $n) {
            $eba = new Norkebatzi();
            $eba->setNorkeu($n->getNorkeu());
            $eba->setNorkes($n->getNorkes());
            $eba->setOrigenid($n->getId());
            $eba->setUdala($desUdala);
            $em->persist($eba);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** KONTZEPTU MOTA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Kontzeptu motak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kontzeptumota','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Nork ebatzi kopiatzen...');
        $oriKontzeptumota = $em->getRepository('BackendBundle:Kontzeptumota')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Kontzeptumota $k */
        foreach ($oriKontzeptumota as $k) {
            $km = new Kontzeptumota();
            $km->setUdala($desUdala);
            $km->setOrigenid($k->getId());
            $km->setMotaeu($k->getMotaeu());
            $km->setMotaes($k->getMotaes());
            $em->persist($km);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** KONTZEPTUa ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Kontzeptuak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kontzeptua','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Kontzeptuak kopiatzen...');
        $oriKontzeptuak = $em->getRepository('BackendBundle:Kontzeptua')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Kontzeptua $k */
        foreach ($oriKontzeptuak as $k) {
            $ko = new Kontzeptua();
            $ko->setOrigenid($k->getId());
            $ko->setUdala($desUdala);
            if ($k->getAzpiatala()) {
                /** @var Azpiatala $_azpi_atala */
                $_azpi_atala= $em->getRepository('BackendBundle:Azpiatala')->findOneBy(
                    array(
                        'origenid' => $k->getAzpiatala()->getId(),
                    )
                );
                $ko->setAzpiatala($_azpi_atala);
            }
            $ko->setKodea($k->getKodea());
            if ($k->getBaldintza()) {
                /** @var Baldintza $_baldintza */
                $_baldintza = $em->getRepository('BackendBundle:Baldintza')->findOneBy(
                    array(
                        'origenid' => $k->getBaldintza()->getId(),
                    )
                );
                $ko->setBaldintza($_baldintza);
            }
            $ko->setKontzeptuaes($k->getKontzeptuaes());
            $ko->setKontzeptuaeu($k->getKontzeptuaeu());
            if ($k->getKontzeptumota()) {
                /** @var Kontzeptumota $_kontzeptu_mota */
                $_kontzeptu_mota = $em->getRepository('BackendBundle:Kontzeptumota')->findOneBy(
                    array(
                        'origenid' => $k->getKontzeptumota()->getId(),
                    )
                );
                $ko->setKontzeptumota($_kontzeptu_mota);
            }
            $ko->setKopurua($k->getKopurua());
            $ko->setUnitatea($k->getUnitatea());
            $em->persist($ko);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** KANAL MOTA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Kanal motak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kanalmota','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Nork ebatzi kopiatzen...');
        $oriKanalMota = $em->getRepository('BackendBundle:Kanalmota')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Kanalmota $k */
        foreach ($oriKanalMota as $k) {
            $km = new Kanalmota();
            $km->setUdala($desUdala);
            $km->setOrigenid($k->getId());
            $km->setMotaes($k->getMotaes());
            $km->setMotaeu($k->getMotaeu());
            $km->setEsteka($k->getEsteka());
            $km->setIkonoa($k->getIkonoa());
            $em->persist($km);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** KANALA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Kanalak ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kanala','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Kanalak kopiatzen...');
        $oriKanalak = $em->getRepository('BackendBundle:Kanala')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Kanala $k */
        foreach ($oriKanalak as $k) {
            $ka = new Kanala();
            $ka->setOrigenid($k->getId());
            $ka->setUdala($desUdala);
            $ka->setDeskribapenaeu($k->getDeskribapenaeu());
            $ka->setDeskribapenaes($k->getDeskribapenaes());
            $ka->setEstekaes($k->getEstekaes());
            $ka->setEstekaeu($k->getEstekaeu());
            $ka->setIzenaes($k->getIzenaes());
            $ka->setIzenaeu($k->getIzenaeu());
            if ($k->getBarrutia()) {
                /** @var Barrutia $_barrutia */
                $_barrutia = $em->getRepository('BackendBundle:Barrutia')->findOneBy(
                    array(
                        'origenid' => $k->getBarrutia()->getId(),
                    )
                );
                $ka->setBarrutia($_barrutia);
            }
            if ($k->getEraikina()) {
                /** @var Eraikina $_eraikina */
                $_eraikina = $em->getRepository('BackendBundle:Eraikina')->findOneBy(
                    array(
                        'origenid' => $k->getEraikina()->getId(),
                    )
                );
                $ka->setEraikina($_eraikina);
            }
            $ka->setErakutsi($k->getErakutsi());
            $ka->setFax($k->getFax());
            if ($k->getKalea()) {
                /** @var Kalea $_kalea */
                $_kalea = $em->getRepository('BackendBundle:Kalea')->findOneBy(
                    array(
                        'origenid' => $k->getKalea()->getId(),
                    )
                );
                $ka->setKalea($_kalea);
            }
            $ka->setKalezbkia($k->getKalezbkia());
            $ka->setOrdutegia($k->getOrdutegia());
            $ka->setPostakodea($k->getPostakodea());
            $ka->setTelefonoa($k->getTelefonoa());
            $ka->setTelematikoa($k->getTelematikoa());
            if ($k->getKanalmota()) {
                /** @var Kanalmota $_kanal_mota */
                $_kanal_mota = $em->getRepository('BackendBundle:Kanalmota')->findOneBy(
                    array(
                        'origenid' => $k->getKanalmota()->getId(),
                    )
                );
                $ka->setKanalmota($_kanal_mota);
            }
            $em->persist($ka);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ISILTASUN ADMINISTRATIBOA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Isiltasun administratiboa ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:IsiltasunAdministratiboa','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Isiltasun administratiboa kopiatzen...');
        $oriIsiltasunAdministratiboa = $em->getRepository('BackendBundle:IsiltasunAdministratiboa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var IsiltasunAdministratiboa $i */
        foreach ($oriIsiltasunAdministratiboa as $i) {
            $isi = new IsiltasunAdministratiboa();
            $isi->setUdala($desUdala);
            $isi->setOrigenid($i->getId());
            $isi->setIsiltasunes($i->getIsiltasunes());
            $isi->setIsiltasuneu($i->getIsiltasuneu());
            $em->persist($isi);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** FITXAK ***********************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Fitxa ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Fitxa','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Fitxak kopiatzen...');
        $oriFitxa = $em->getRepository('BackendBundle:Fitxa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var Fitxa $f */
        foreach ($oriFitxa as $f) {
            $fitxa = new Fitxa();
            $fitxa->setUdala($desUdala);
            $fitxa->setOrigenid($f->getId());
            $fitxa->setAraudiaes($f->getAraudiaes());
            $fitxa->setAraudiaeu($f->getAraudiaeu());
            $fitxa->setArduraaitorpena($f->getArduraaitorpena());
            if ($f->getArrunta()) {
                /** @var Arrunta $_arrunta */
                $_arrunta = $em->getRepository('BackendBundle:Arrunta')->findOneBy(
                    array(
                        'origenid' => $f->getArrunta()->getId(),
                    )
                );
                $fitxa->setArrunta($_arrunta);
            }
            if ($f->getAurreikusi()) {
                /** @var Aurreikusi $_aurreikusi */
                $_aurreikusi = $em->getRepository('BackendBundle:Aurreikusi')->findOneBy(
                    array(
                        'origenid' => $f->getAurreikusi()->getId(),
                    )
                );
                $fitxa->setAurreikusi($_aurreikusi);
            }
            if ($f->getAzpisaila()) {
                /** @var Azpisaila $_azpi_saila */
                $_azpi_saila =$em->getRepository('BackendBundle:Azpisaila')->findOneBy(
                    array(
                        'origenid' => $f->getAzpisaila()->getId(),
                    )
                );
                $fitxa->setAzpisaila($_azpi_saila);
            }
            $fitxa->setBesteak1es($f->getBesteak1es());
            $fitxa->setBesteak1eu($f->getBesteak1eu());
            $fitxa->setBesteak2eu($f->getBesteak2eu());
            $fitxa->setBesteak2es($f->getBesteak2es());
            $fitxa->setBesteak3es($f->getBesteak3es());
            $fitxa->setBesteak3eu($f->getBesteak3eu());
            if ($f->getDatuenbabesa()) {
                /** @var Datuenbabesa $_datuen_babesa */
                $_datuen_babesa = $em->getRepository('BackendBundle:Datuenbabesa')->findOneBy(
                    array(
                        'origenid' => $f->getDatuenbabesa()->getId(),
                    )
                );
                $fitxa->setDatuenbabesa($_datuen_babesa);
            }
            $fitxa->setDatuenbabesaes($f->getDatuenbabesaes());
            $fitxa->setDatuenbabesaeu($f->getDatuenbabesaeu());
            $fitxa->setDeskribapenaes($f->getDeskribapenaes());
            $fitxa->setDeskribapenaeu($f->getDeskribapenaeu());
            $fitxa->setDoklagunes($f->getDoklagunes());
            $fitxa->setDoklaguneu($f->getDoklaguneu());
            $fitxa->setDokumentazioaes($f->getDokumentazioaes());
            $fitxa->setDokumentazioaeu($f->getDokumentazioaeu());
            $fitxa->setEbazpensinpli($f->getEbazpensinpli());
            $fitxa->setEspedientekodea($f->getEspedientekodea());
            $fitxa->setExpedientes($f->getExpedientes());
            $fitxa->setHelburuaes($f->getHelburuaes());
            $fitxa->setHelburuaeu($f->getHelburuaeu());
            $fitxa->setHitzarmena($f->getHitzarmena());
            if ($f->getIsiltasunadmin()) {
                /** @var IsiltasunAdministratiboa $_isiltasun_admin */
                $_isiltasun_admin =$em->getRepository('BackendBundle:IsiltasunAdministratiboa')->findOneBy(
                    array(
                        'origenid' => $f->getIsiltasunadmin()->getId(),
                    )
                );
                $fitxa->setIsiltasunadmin($_isiltasun_admin);
            }
            $fitxa->setJarraibideakes($f->getJarraibideakes());
            $fitxa->setJarraibideakeu($f->getJarraibideakeu());
            $fitxa->setKanalaes($f->getKanalaes());
            $fitxa->setKanalaeu($f->getKanalaeu());
            $fitxa->setKontsultak($f->getKontsultak());
            $fitxa->setKostuaes($f->getKostuaes());
            $fitxa->setKostuaeu($f->getKostuaeu());
            if ($f->getNorkebatzi()) {
                /** @var Norkebatzi $_nork_ebatzi */
                $_nork_ebatzi = $em->getRepository('BackendBundle:Norkebatzi')->findOneBy(
                    array(
                        'origenid' => $f->getNorkebatzi()->getId(),
                    )
                );
                $fitxa->setNorkebatzi($_nork_ebatzi);
            }
            $fitxa->setNorkes($f->getNorkes());
            $fitxa->setNorkeu($f->getNorkeu());
            $fitxa->setNorkonartues($f->getNorkonartues());
            $fitxa->setNorkonartueu($f->getNorkonartueu());
            $fitxa->setOharrakes($f->getOharrakes());
            $fitxa->setOharrakeu($f->getOharrakeu());
            $fitxa->setParametroa($f->getParametroa());
            $fitxa->setProzeduraes($f->getProzeduraes());
            $fitxa->setProzeduraeu($f->getProzeduraeu());
            $fitxa->setPublikoa($f->getPublikoa());
            if ($f->getZerbitzua()) {
                /** @var Zerbitzua $_zerbitzua */
                $_zerbitzua = $em->getRepository('BackendBundle:Zerbitzua')->findOneBy(
                    array(
                        'origenid' => $f->getZerbitzua()->getId(),
                    )
                );
                $fitxa->setZerbitzua($_zerbitzua);
            }
            $em->persist($fitxa);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** FITXA - ARAUDIA ***********************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Fitxa-Araudia ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:FitxaAraudia','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Fitxa-Araudia kopiatzen...');
        $oriFitxaAraudia= $em->getRepository('BackendBundle:FitxaAraudia')->findBy(array('udala' => $oriUdala->getId()));
        /** @var FitxaAraudia $fa */
        foreach ($oriFitxaAraudia as $fa) {
            $fiar = new FitxaAraudia();
            $fiar->setOrigenid($fa->getId());
            $fiar->setUdala($desUdala);
            $fiar->setAtalaes($fa->getAtalaes());
            $fiar->setAtalaeu($fa->getAtalaeu());
            /** @var Araudia $_araudia */
            $_araudia = $em->getRepository('BackendBundle:Araudia')->findOneBy(
                array(
                    'origenid' => $fa->getAraudia()->getId(),
                )
            );
            $fiar->setAraudia($_araudia);
            /** @var Fitxa $_fitxa */
            $_fitxa = $em->getRepository('BackendBundle:Fitxa')->findOneBy(
                array(
                    'origenid' => $fa->getFitxa()->getId(),
                )
            );
            $fiar->setFitxa($_fitxa);
            $em->persist($fam);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** FITXA - PROZEDURA ***********************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Fitxa-Prozedura ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:FitxaProzedura','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Fitxa-Prozedura kopiatzen...');
        $oriFitxaProzedura = $em->getRepository('BackendBundle:FitxaProzedura')->findBy(array('udala' => $oriUdala->getId()));
        /** @var FitxaProzedura $fp */
        foreach ($oriFitxaProzedura as $fp) {
            $fipo = new FitxaProzedura();
            /** @var Fitxa $_fitxa */
            $_fitxa = $em->getRepository('BackendBundle:Fitxa')->findOneBy(
                array(
                    'origenid' => $fp->getFitxa()->getId(),
                )
            );
            $fipo->setFitxa($_fitxa);
            $fipo->setUdala($desUdala);
            $fipo->setOrigenid($fp->getId());
            $fipo->setOrdena($fp->getOrdena());
            /** @var Prozedura $_prozedura */
            $_prozedura = $em->getRepository('BackendBundle:Prozedura')->findOneBy(
                array(
                    'origenid' => $fp->getProzedura()->getId(),
                )
            );
            $fipo->setProzedura($_prozedura);
            $em->persist($fipo);
        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** FITXA - KOSTUA ***********************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('-- Helmugako Fitxa-Kostua ezabatzen...');
        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:FitxaKostua','f')->where('f.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
        $output->writeln('Ok');
        $output->write('++ Fitxa-Kostua kopiatzen...');
        $oriFitxaKostua = $em->getRepository('BackendBundle:FitxaKostua')->findBy(array('udala' => $oriUdala->getId()));
        /** @var FitxaKostua $fk */
        foreach ($oriFitxaKostua as $fk) {
            $fiko = new FitxaKostua();
            $fiko->setOrigenid($fk->getId());
            $fiko->setUdala($desUdala);
            /** @var Fitxa $_fitxa */
            $_fitxa = $em->getRepository('BackendBundle:Fitxa')->findOneBy(
                array(
                    'origenid' => $fk->getFitxa()->getId(),
                )
            );
            $fiko->setFitxa($_fitxa);
            $fiko->setKostua($fk->getKostua());
            $em->persist($fiko);

        }
        $output->write('OK.');
        $output->writeln('');
        $output->writeln('');
        $em->flush();


        $output->writeln('');
        $output->writeln('Prozesua ongi amaitu da.');
    }
}
