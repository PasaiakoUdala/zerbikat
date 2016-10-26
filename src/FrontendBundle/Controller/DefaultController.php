<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Fitxa;
use GuzzleHttp;

class DefaultController extends Controller
{

    /**
     * @Route("/{udala}/{_locale}/", name="frontend_fitxa_index",
     *         requirements={
     *           "_locale": "eu|es",
     *           "udala": "\d+"
     *     }
     * )
     */
    public function indexAction($udala)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('
          SELECT f 
            FROM BackendBundle:Fitxa f 
              LEFT JOIN BackendBundle:Udala u  WITH f.udala=u.id
            WHERE u.kodea = :udala
            ORDER BY f.kontsultak DESC 
        ');
        $query->setParameter('udala', $udala);
        $fitxak = $query->getResult();

        $query = $em->createQuery('
          SELECT f 
            FROM BackendBundle:Familia f 
              LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
            WHERE u.kodea = :udala AND f.parent is NULL 
            ORDER BY f.ordena ASC NULLS LAST 
        ');
        $query->setParameter('udala', $udala);
        $familiak = $query->getResult();

        return $this->render('frontend\index.html.twig', array(
            'fitxak' => $fitxak,
            'familiak' => $familiak,
            'udala'=>$udala,
        ));
    }


    /**
     * Finds and displays a Fitxa entity.
     *
     * @Route("/{udala}/{_locale}/{id}", name="frontend_fitxa_show",
     *         requirements={
     *           "_locale": "eu|es",
     *           "udala": "\d+"
     *           }
     * )
     * @Method("GET")
     */
    public function showAction(Fitxa $fitxa,$udala)
    {
        $em = $this->getDoctrine()->getManager();
        $kanalmotak=$em->getRepository('BackendBundle:Kanalmota')->findAll();


        $query = $em->createQuery('
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
            WHERE u.kodea = :udala
        ');
        $query->setParameter('udala', $udala);
        //$eremuak = $query->getResult();
        $eremuak = $query->getSingleResult();

        $query = $em->createQuery('
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
            WHERE u.kodea = :udala
        ');
        $query->setParameter('udala', $udala);
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

        return $this->render('frontend/show.html.twig', array(
            'fitxa' => $fitxa,
            'kanalmotak'=>$kanalmotak,
            'eremuak'=> $eremuak,
            'labelak'=> $labelak,
            'udala' =>$udala,
            'kostuZerrenda'=>$kostuZerrenda
        ));
    }


    /**
     * Finds and displays a Fitxa entity.
     *
     * @Route("/{udala}/{_locale}/pdf/{id}", name="frontend_fitxa_pdf")
     * @Method("GET")
     */
    public function pdfAction(Fitxa $fitxa,$udala)
    {
        $em = $this->getDoctrine()->getManager();
        $kanalmotak=$em->getRepository('BackendBundle:Kanalmota')->findAll();

        $query = $em->createQuery('
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
            WHERE u.kodea = :udala
        ');
        $query->setParameter('udala', $udala);
        $eremuak = $query->getSingleResult();

        $query = $em->createQuery('
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
            WHERE u.kodea = :udala
        ');
        $query->setParameter('udala', $udala);
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

        $html= $this->render('frontend/pdf.html.twig', array(
            'fitxa' => $fitxa,
            'kanalmotak'=>$kanalmotak,
            'eremuak'=> $eremuak,
            'labelak'=> $labelak,
            'udala' =>$udala,
            'kostuZerrenda'=>$kostuZerrenda
        ));

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor($udala);
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
     * Finds and displays a Fitxa entity.
     *
     * @Route("/{udala}/{_locale}/pdfelebi/{id}", name="frontend_fitxa_pdfelebi")
     * @Method("GET")
     */
    public function pdfelebiAction(Fitxa $fitxa,$udala)
    {

        $em = $this->getDoctrine()->getManager();
        $kanalmotak=$em->getRepository('BackendBundle:Kanalmota')->findAll();

        $query = $em->createQuery('
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
            WHERE u.kodea = :udala
        ');
        $query->setParameter('udala', $udala);
        $eremuak = $query->getSingleResult();

        $query = $em->createQuery('
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f LEFT JOIN BackendBundle:Udala u WITH f.udala=u.id
            WHERE u.kodea = :udala
        ');
        $query->setParameter('udala', $udala);
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

        $html= $this->render('frontend/pdfelebi.html.twig', array(
            'fitxa' => $fitxa,
            'kanalmotak'=>$kanalmotak,
            'eremuak'=> $eremuak,
            'labelak'=> $labelak,
            'udala' =>$udala,
            'kostuZerrenda'=>$kostuZerrenda
        ));

        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor($udala);
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
    
    
    
}
