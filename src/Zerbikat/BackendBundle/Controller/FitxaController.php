<?php

namespace Zerbikat\BackendBundle\Controller;

use Pagerfanta\Adapter\ArrayAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Fitxa;
use Zerbikat\BackendBundle\Form\FitxaType;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;

use GuzzleHttp;

use Doctrine\Common\Collections\ArrayCollection;



/**
 * Fitxa controller.
 *
 * @Route("/fitxa")
 */
class FitxaController extends Controller
{
//* @Route("/", name="fitxa_index")

    /**
     * Lists all Fitxa entities.
     *
     * @Route("/", defaults={"page" = 1}, name="fitxa_index")
     * @Route("/page{page}", name="fitxa_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
//        $erab=$this->getUser();
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_USER'))
        {
            $em = $this->getDoctrine()->getManager();
//            $fitxas = $em->getRepository('BackendBundle:Fitxa')->findAll();
//            $fitxas = $em->getRepository('BackendBundle:Fitxa')
//                ->findBy( array(), array('azpisaila'=>'ASC') );


            $query = $em->createQuery('SELECT f 
              FROM BackendBundle:Fitxa f
              LEFT JOIN f.azpisaila a
              ORDER BY a.saila ASC, f.azpisaila ASC
        ');
            $fitxas = $query->getResult();



            
            

            $adapter = new ArrayAdapter($fitxas);
            $pagerfanta = new Pagerfanta($adapter);

            $deleteForms = array();
            foreach ($fitxas as $fitxa) {
                $deleteForms[$fitxa->getId()] = $this->createDeleteForm($fitxa)->createView();
            }

            try {
                $entities = $pagerfanta
                    // Le nombre maximum d'éléments par page
                    ->setMaxPerPage($this->getUser()->getUdala()->getOrrikatzea())
                    // Notre position actuelle (numéro de page)
                    ->setCurrentPage($page)
                    // On récupère nos entités via Pagerfanta,
                    // celui-ci s'occupe de limiter la requête en fonction de nos réglages.
                    ->getCurrentPageResults()
                ;
            } catch (\Pagerfanta\Exception\NotValidCurrentPageException $e) {
                throw $this->createNotFoundException("Orria ez da existitzen");
            }

//            'fitxas' => $fitxas,
            return $this->render('fitxa/index.html.twig', array(
                'deleteforms' => $deleteForms,
                'fitxas' => $entities,
                'pager' => $pagerfanta,
            ));
        }
    }

    /**
     * Creates a new Fitxa entity.
     *
     * @Route("/new", name="fitxa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_USER')) {
            $fitxa = new Fitxa();
//            $fitxa->setUdala($this->getUser()->getUdala());

            $form = $this->createForm('Zerbikat\BackendBundle\Form\FitxaType', $fitxa);
            $form->handleRequest($request);

//            $form->getData()->setUdala($this->getUser()->getUdala());
//            $form->setData($form->getData());

            $em = $this->getDoctrine()->getManager();

            if ($form->isSubmitted() && $form->isValid()) {
                $fitxa->setCreatedAt(new \DateTime());
//                $em = $this->getDoctrine()->getManager();
                $em->persist($fitxa);
                $em->flush();

                return $this->redirectToRoute('fitxa_show', array('id' => $fitxa->getId()));
            } else
            {
                $form->getData()->setUdala($this->getUser()->getUdala());
                $form->setData($form->getData());
            }

//            $query = $em->createQuery('
//            SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
//              FROM BackendBundle:Eremuak f
//          ');
//            //$eremuak = $query->getResult();
//            $eremuak = $query->getSingleResult();
//
//            $query = $em->createQuery('
//            SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
//              FROM BackendBundle:Eremuak f
//          ');
//            $labelak = $query->getSingleResult();

            $query = $em->createQuery('
            SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
              FROM BackendBundle:Eremuak f 
              WHERE f.udala = :udala
          ');
            $query->setParameter('udala', $this->getUser()->getUdala());
            $eremuak = $query->getSingleResult();
//        }
            $query = $em->createQuery('
            SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
              FROM BackendBundle:Eremuak f
              WHERE f.udala = :udala
          ');
            $query->setParameter('udala', $this->getUser()->getUdala());
            $labelak = $query->getSingleResult();

            return $this->render('fitxa/new.html.twig', array(
                'fitxa' => $fitxa,
                'form' => $form->createView(),
                'eremuak' => $eremuak,
                'labelak' => $labelak
            ));
        }
    }
    /**
     * Finds and displays a Fitxa entity.
     *
     * @Route("/{id}", name="fitxa_show")
     * @Method("GET")
     */
    public function showAction(Fitxa $fitxa)
    {
        $deleteForm = $this->createDeleteForm($fitxa);

        $em = $this->getDoctrine()->getManager();
        $kanalmotak=$em->getRepository('BackendBundle:Kanalmota')->findAll();

        $kostuZerrenda= array();
        foreach ($fitxa->getKostuak() as $kostu)
        {
//            dump($kostu);
            $client = new GuzzleHttp\Client();

            $api=$this->container->getParameter('zzoo_aplikazioaren_API_url');
//            $proba = $client->request( 'GET', 'http://zergaordenantzak.dev/app_dev.php/api/azpiatalas/'.$kostu->getKostua().'.json' );
            $proba = $client->request( 'GET', $api.'/azpiatalas/'.$kostu->getKostua().'.json' );

            $fitxaKostua = (string)$proba->getBody();
            $array = json_decode($fitxaKostua, true);
//            dump($fitxaKostua);
//            dump($array);
            $kostuZerrenda[] = $array;
        }
//        dump($kostuZerrenda);

        $query = $em->createQuery('
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', $fitxa->getUdala());
        $eremuak = $query->getSingleResult();

        $query = $em->createQuery('
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', $fitxa->getUdala());
        $labelak = $query->getSingleResult();

        return $this->render('fitxa/show.html.twig', array(
            'fitxa' => $fitxa,
            'kanalmotak'=>$kanalmotak,
            'delete_form' => $deleteForm->createView(),
            'eremuak'=> $eremuak,
            'labelak'=> $labelak,
            'kostuZerrenda'=>$kostuZerrenda
        ));
    }

    /**
     * Finds and displays a Fitxa entity.
     *
     * @Route("/pdf/{id}", name="fitxa_pdf")
     * @Method("GET")
     */
    public function pdfAction(Fitxa $fitxa)
    {
        $deleteForm = $this->createDeleteForm($fitxa);

        $em = $this->getDoctrine()->getManager();
        $kanalmotak=$em->getRepository('BackendBundle:Kanalmota')->findAll();

        $query = $em->createQuery('
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala            
        ');
        $query->setParameter('udala', $fitxa->getUdala());
        $eremuak = $query->getSingleResult();

        $query = $em->createQuery('
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', $fitxa->getUdala());
        $labelak = $query->getSingleResult();

        $kostuZerrenda= array();
        foreach ($fitxa->getKostuak() as $kostu)
        {
            $client = new GuzzleHttp\Client();

            $api=$this->container->getParameter('zzoo_aplikazioaren_API_url');
//            $proba = $client->request( 'GET', 'http://zergaordenantzak.dev/app_dev.php/api/azpiatalas/'.$kostu->getKostua().'.json' );
            $proba = $client->request( 'GET', $api.'/azpiatalas/'.$kostu->getKostua().'.json' );

            $fitxaKostua = (string)$proba->getBody();
            $array = json_decode($fitxaKostua, true);
            $kostuZerrenda[] = $array;
        }


        $html= $this->render('fitxa/pdf.html.twig', array(
            'fitxa' => $fitxa,
            'kanalmotak'=>$kanalmotak,
            'delete_form' => $deleteForm->createView(),
            'eremuak'=> $eremuak,
            'labelak'=> $labelak,
            'kostuZerrenda'=>$kostuZerrenda
        ));

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor($this->getUser()->getUdala());
//        $pdf->SetTitle(('Our Code World Title'));
        $pdf->SetTitle(($fitxa->getDeskribapenaeu()));
        $pdf->SetSubject($fitxa->getDeskribapenaes());
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();

        $filename = $fitxa->getEspedientekodea().".".$fitxa->getDeskribapenaeu();

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html->getContent(), $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
    }


    /**
     * Displays a form to edit an existing Fitxa entity.
     *
     * @Route("/{id}/edit", name="fitxa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fitxa $fitxa)
    {
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_USER')) && ($fitxa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $deleteForm = $this->createDeleteForm($fitxa);
            $editForm = $this->createForm('Zerbikat\BackendBundle\Form\FitxaType', $fitxa);

            // Create an ArrayCollection of the current Kostuak objects in the database
            $originalKostuak = new ArrayCollection();
            foreach ($fitxa->getKostuak() as $kostu) {
                $originalKostuak->add($kostu);
            }
            // Create an ArrayCollection of the current Araudiak objects in the database
            $originalAraudiak = new ArrayCollection();
            foreach ($fitxa->getAraudiak() as $araudi) {
                $originalAraudiak->add($araudi);
            }
            // Create an ArrayCollection of the current Prozedurak objects in the database
            $originalProzedurak = new ArrayCollection();
            foreach ($fitxa->getProzedurak() as $prozedura) {
                $originalProzedurak->add($prozedura);
            }

            $editForm->handleRequest($request);
            $em = $this->getDoctrine()->getManager();

            if ($editForm->isSubmitted() && $editForm->isValid())
            {

                foreach ($originalKostuak as $kostu)
                {
                    if (false === $fitxa->getKostuak()->contains($kostu))
                    {
                        $kostu->setFitxa(null);
                        $em->remove($kostu);
                        $em->persist($fitxa);
                    }
                }
                foreach ($originalAraudiak as $araudi)
                {
                    if (false === $fitxa->getAraudiak()->contains($araudi))
                    {
                        $araudi->setFitxa(null);
                        $em->remove($araudi);
                        $em->persist($fitxa);
                    }
                }
                foreach ($originalProzedurak as $prozedura)
                {
                    if (false === $fitxa->getProzedurak()->contains($prozedura))
                    {
                        $prozedura->setFitxa(null);
                        $em->remove($prozedura);
                        $em->persist($fitxa);
                    }
                }

                $fitxa->setUpdatedAt(new \DateTime());
                $em->persist($fitxa);
                $em->flush();
                return $this->redirectToRoute('fitxa_edit', array('id' => $fitxa->getId()));
            }
            $query = $em->createQuery('
              SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
                FROM BackendBundle:Eremuak f
                WHERE f.udala = :udala                
            ');
            $query->setParameter('udala', $fitxa->getUdala());
            $eremuak = $query->getSingleResult();

            $query = $em->createQuery('
              SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
                FROM BackendBundle:Eremuak f
                WHERE f.udala = :udala                
            ');
            $query->setParameter('udala', $fitxa->getUdala());
            $labelak = $query->getSingleResult();

    //        }
//            if ($fitxa->getUdala()==$this->getUser()->getUdala()) {
                return $this->render('fitxa/edit.html.twig', array(
                    'fitxa' => $fitxa,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'eremuak' => $eremuak,
                    'labelak' => $labelak
                ));
//            } else
//            {
//                return $this->redirectToRoute('fitxa_index');
//            }
        }else
        {
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Deletes a Fitxa entity.
     *
     * @Route("/{id}/del", name="fitxa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fitxa $fitxa)
    {

        //udala egokia den eta admin baimena duen egiaztatu
        $auth_checker = $this->get('security.authorization_checker');
        if((($auth_checker->isGranted('ROLE_ADMIN')) && ($fitxa->getUdala()==$this->getUser()->getUdala()))
            ||($auth_checker->isGranted('ROLE_SUPER_ADMIN')))
        {
            $form = $this->createDeleteForm($fitxa);
            $form->handleRequest($request);
//            if ($form->isSubmitted() && $form->isValid()) {
            if ($form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($fitxa);
                $em->flush();
            }else
            {
 //               dump($form);
//                dump($request);

            }
            return $this->redirectToRoute('fitxa_index');
        }else
        {
            //baimenik ez
            return $this->redirectToRoute('backend_errorea');
        }
    }

    /**
     * Creates a form to delete a Fitxa entity.
     *
     * @param Fitxa $fitxa The Fitxa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fitxa $fitxa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fitxa_delete', array('id' => $fitxa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }




}
