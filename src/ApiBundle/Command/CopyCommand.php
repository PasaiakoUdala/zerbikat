<?php

namespace ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Zerbikat\BackendBundle\Entity\Araudia;
use Zerbikat\BackendBundle\Entity\Araumota;
use Zerbikat\BackendBundle\Entity\Arrunta;
use Zerbikat\BackendBundle\Entity\Aurreikusi;
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
use Zerbikat\BackendBundle\Entity\Kalea;
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
        /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
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
        $output->write('Arau Mota kopiatzen ');
        $oriArauMota = $em->getRepository('BackendBundle:Araumota')->findBy(array('udala' => $oriUdala->getId()));

        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Araumota','am')->where('am.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ARAUDIA *******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Araudia kopiatzen ');
        $oriAraudia = $em->getRepository('BackendBundle:Araudia')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Araudia','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ARRUNTA *******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Arrunta kopiatzen ');
        $oriArrunta = $em->getRepository('BackendBundle:Arrunta')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Arrunta','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** AURREIKUSI*****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Aurreikusi kopiatzen ');
        $oriAurreikusi = $em->getRepository('BackendBundle:Aurreikusi')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Aurreikusi','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BARRUTIA*******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Barrutia kopiatzen ');
        $oriBarrutia = $em->getRepository('BackendBundle:Barrutia')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Barrutia','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ERAIKINA ******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Eraikina kopiatzen ');
        $oriEraikina = $em->getRepository('BackendBundle:Eraikina')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Eraikina','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** Kalea ******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Kalea kopiatzen ');
        $oriKalea= $em->getRepository('BackendBundle:Kalea')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Kalea','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** SAILA *********************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Saila kopiatzen ');
        $oriSaila= $em->getRepository('BackendBundle:Saila')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Saila','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** AZPISAILA *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Azpisaila kopiatzen ');
        $oriAzpisaila= $em->getRepository('BackendBundle:Azpisaila')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Azpisaila','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BESTEAK1*******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Besteak1 kopiatzen ');
        $oriBesteak1= $em->getRepository('BackendBundle:Besteak1')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Besteak1','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BESTEAK2 ******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Besteak2 kopiatzen ');
        $oriBesteak2= $em->getRepository('BackendBundle:Besteak2')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Besteak2','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();

        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BESTEAK3*******************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Besteak3 kopiatzen ');
        $oriBesteak3= $em->getRepository('BackendBundle:Besteak3')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Besteak3','a')->where('a.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();
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
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** DATUEN BABESA *************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Datuen babesa kopiatzen ');
        $oriDatuenBabesa = $em->getRepository('BackendBundle:Datuenbabesa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Datuenbabesa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();

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
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ESPEDIENTE KUDEATZAILEA *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Espediente kudeatzailea kopiatzen ');
        $oriEspediente = $em->getRepository('BackendBundle:Espedientekudeaketa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Zerbitzua','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();

        /** @var Espedientekudeaketa $e */
        foreach ($oriEspediente as $e) {
            $espe = new Espedientekudeaketa();
            $espe->setOrigenid($e->getId());
            $espe->setIzenaeu($e->getIzenaeu());
            $espe->setIzenaes($e->getIzenaes());
            $espe->setUrles($e->getUrles());
            $espe->setUrleu($e->getUrleu());
            $em->persist($espe);
        }
        $output->write('OK.');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ZERBITZUA *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Zerbitzuak kopiatzen ');
        $oriZerbitzua = $em->getRepository('BackendBundle:Zerbitzua')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Zerbitzua','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();

        /** @var Zerbitzua $z */
        foreach ($oriZerbitzua as $z) {
            $zer = new Zerbitzua();
            $zer->setOrigenid($z->getId());
            $zer->setKodea($z->getKodea());
            $zer->setUdala($desUdala);
            $zer->setErroaes($z->getErroaes());
            $zer->setErroaeu($z->getErroaeu());
            /** @var Espedientekudeaketa $_espediente */
            $_espediente = $em->getRepository('BackendBundle:Espedientekudeaketa')->findOneBy(
                array(
                    'origenid' => $z->getEspedientekudeaketa()->getId(),

                    $em->persist($zer),
                )
            );
            $zer->setEspedientekudeaketa($_espediente);
            $em->persist($zer);
        }
        $output->write('OK.');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** BALDINTZA *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Baldintza kopiatzen ');
        $oriBaldintza = $em->getRepository('BackendBundle:Baldintza')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Zerbitzua','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();

        /** @var Baldintza $b */
        foreach ($oriBaldintza as $b) {
            $bal = new Baldintza();
            $bal->setOrigenid($b->getId());
            $bal->setUdala($desUdala);
            $bal->setBaldintzaes($b->getBaldintzaes());
            $bal->setBaldintzaeu($b->detBaldintzaeu());
            $em->persist($bal);
        }
        $output->write('OK.');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** DOKLAGUN *****************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Doklagun kopiatzen ');
        $oriDokLagun = $em->getRepository('BackendBundle:Doklagun')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Zerbitzua','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();

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
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** DOKUMENTO MOTA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Dokumentu motak kopiatzen ');
        $oriDokMota = $em->getRepository('BackendBundle:Dokumentumota')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Zerbitzua','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();

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
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** DOKUMENTAZIOA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Dokumentazioa kopiatzen ');
        $oriDokumentazioa = $em->getRepository('BackendBundle:Dokumentazioa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Dokumentazioa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();

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
            /** @var Dokumentumota $_dokmota */
            $_dokmota= $em->getRepository('BackendBundle:Dokumentazioa')->findOneBy(
                array(
                    'origenid' => $d->getDokumentumota()->getId(),

                    $em->persist($do),
                )
            );
            $do->setDokumentumota($_dokmota);
            $em->persist($do);

        }
        $output->write('OK.');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** EREMUA  ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Eremuak kopiatzen ');
        $oriEremua = $em->getRepository('BackendBundle:Eremuak')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Eremuak','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();

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
            $ere->setTramitealabeles($e->getTramitealabeles());
            $ere->setTramitealabeleu($e->getTramitealabeleu());
            $ere->setTramiteatable($e->getTramiteatable());
            $ere->setTramiteatext($e->getTramiteatext());
            $ere->setUdalsailalabeles($e->getUdalsailalabeles());
            $ere->setUdalsailalabeleu($e->getUdalsailalabeleu());
            $em->persist($ere);
        }
        $output->write('OK.');
        $output->writeln('');
        $em->flush();


        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*** ETIKETA ************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        /*******************************************************************************************************************************************************/
        $output->write('Etiketak kopiatzen ');
        $oriEtiketa = $em->getRepository('BackendBundle:Etiketa')->findBy(array('udala' => $oriUdala->getId()));
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $em->createQueryBuilder()->delete()->from('BackendBundle:Etiketa','d')->where('d.udala = :udalaID');
        $qb->setParameter('udalaID', $desUdala);
        $qb->getQuery()->execute();

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
        $em->flush();


























        $output->writeln('');
        $output->writeln('Prozesua ongi amaitu da.');
    }
}
