<?php

namespace Zerbikat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zerbikat\BackendBundle\Entity\Fitxa;
use Zerbikat\BackendBundle\Form\FitxaType;

/**
 * Fitxa controller.
 *
 * @Route("/fitxa")
 */
class FitxaController extends Controller
{
    /**
     * Lists all Fitxa entities.
     *
     * @Route("/", name="fitxa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fitxas = $em->getRepository('BackendBundle:Fitxa')->findAll();

        return $this->render('fitxa/index.html.twig', array(
            'fitxas' => $fitxas,
        ));
    }

    /**
     * Creates a new Fitxa entity.
     *
     * @Route("/new", name="fitxa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fitxa = new Fitxa();
        $form = $this->createForm('Zerbikat\BackendBundle\Form\FitxaType', $fitxa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fitxa);
            $em->flush();

            return $this->redirectToRoute('fitxa_show', array('id' => $fitxa->getId()));
        }

        return $this->render('fitxa/new.html.twig', array(
            'fitxa' => $fitxa,
            'form' => $form->createView(),
        ));
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

//        $eremuak = $em->getRepository('BackendBundle:Eremuak')->findAll(array('udala'=>'064'));


        $query = $em->createQuery('
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.tramiteatext,f.tramiteatable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', '064');
        //$eremuak = $query->getResult();
        $eremuak = $query->getSingleResult();

        $query = $em->createQuery('
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.tramitealabeleu,f.tramitealabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', '064');
        $labelak = $query->getSingleResult();


        return $this->render('fitxa/show.html.twig', array(
            'fitxa' => $fitxa,
            'kanalmotak'=>$kanalmotak,
            'delete_form' => $deleteForm->createView(),
            'eremuak'=> $eremuak,
            'labelak'=> $labelak
        ));
    }

    /**
     * Displays a form to edit an existing Fitxa entity.
     *
     * @Route("/{id}/edit", name="fitxa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fitxa $fitxa)
    {
        $deleteForm = $this->createDeleteForm($fitxa);
        $editForm = $this->createForm('Zerbikat\BackendBundle\Form\FitxaType', $fitxa);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $em = $this->getDoctrine()->getManager();
            $em->persist($fitxa);
            $em->flush();

            return $this->redirectToRoute('fitxa_edit', array('id' => $fitxa->getId()));
        }

        $query = $em->createQuery('
          SELECT f.oharraktext,f.helburuatext,f.ebazpensinpli,f.arduraaitorpena,f.aurreikusi,f.arrunta,f.isiltasunadmin,f.norkeskatutext,f.norkeskatutable,f.dokumentazioatext,f.dokumentazioatable,f.kostuatext,f.kostuatable,f.araudiatext,f.araudiatable,f.prozeduratext,f.prozeduratable,f.tramiteatext,f.tramiteatable,f.doklaguntext,f.doklaguntable,f.datuenbabesatext,f.datuenbabesatable,f.norkebatzitext,f.norkebatzitable,f.besteak1text,f.besteak1table,f.besteak2text,f.besteak2table,f.besteak3text,f.besteak3table,f.kanalatext,f.kanalatable,f.azpisailatable
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', '064');
        //$eremuak = $query->getResult();
        $eremuak = $query->getSingleResult();

        $query = $em->createQuery('
          SELECT f.oharraklabeleu,f.oharraklabeles,f.helburualabeleu,f.helburualabeles,f.ebazpensinplilabeleu,f.ebazpensinplilabeles,f.arduraaitorpenalabeleu,f.arduraaitorpenalabeles,f.aurreikusilabeleu,f.aurreikusilabeles,f.arruntalabeleu,f.arruntalabeles,f.isiltasunadminlabeleu,f.isiltasunadminlabeles,f.norkeskatulabeleu,f.norkeskatulabeles,f.dokumentazioalabeleu,f.dokumentazioalabeles,f.kostualabeleu,f.kostualabeles,f.araudialabeleu,f.araudialabeles,f.prozeduralabeleu,f.prozeduralabeles,f.tramitealabeleu,f.tramitealabeles,f.doklagunlabeleu,f.doklagunlabeles,f.datuenbabesalabeleu,f.datuenbabesalabeles,f.norkebatzilabeleu,f.norkebatzilabeles,f.besteak1labeleu,f.besteak1labeles,f.besteak2labeleu,f.besteak2labeles,f.besteak3labeleu,f.besteak3labeles,f.kanalalabeleu,f.kanalalabeles,f.epealabeleu,f.epealabeles,f.doanlabeleu,f.doanlabeles,f.azpisailalabeleu,f.azpisailalabeles
            FROM BackendBundle:Eremuak f
            WHERE f.udala = :udala
        ');
        $query->setParameter('udala', '064');
        $labelak = $query->getSingleResult();

//        }
        return $this->render('fitxa/edit.html.twig', array(
            'fitxa' => $fitxa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'eremuak'=> $eremuak,
            'labelak'=> $labelak
        ));
    }

    /**
     * Deletes a Fitxa entity.
     *
     * @Route("/{id}", name="fitxa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fitxa $fitxa)
    {
        $form = $this->createDeleteForm($fitxa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fitxa);
            $em->flush();
        }

        return $this->redirectToRoute('fitxa_index');
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
