<?php
/**
 * User: iibarguren
 * Date: 31/05/16
 * Time: 10:09
 */

namespace ApiBundle\Controller;


use AppBundle\Form\AtalaType;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends FOSRestController
{
    /**
     * Familia guztien zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Bloke guztiak eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @return array data
     *
     * @Annotations\View()
     */
    public function getFamiliakAction()
    {
        $em         = $this->getDoctrine()->getManager();
        $familiak = $em->getRepository('BackendBundle:Familia')->findAll();
        $view = View::create();
        $view->setData($familiak);
        return $view;

    }// "get_familiak"            [GET] /familiak

    /**
     * Familia baten fitxa guztien zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Familia baten fitxak eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @return array data
     *
     * @Annotations\View()
     */
    public function getFitxakAction($id)
    {
        $em         = $this->getDoctrine()->getManager();

        $query = $em->createQuery('
          SELECT f
            FROM BackendBundle:Fitxa f
            ');

//        $query->setParameter('id', $id);

        $fitxak = $query->getResult();
//        dump($fitxak);
        $view = View::create();
        $view->setData($fitxak);
        return $view;

    }// "get_fitxak"            [GET] /fitxak/{id]}



}