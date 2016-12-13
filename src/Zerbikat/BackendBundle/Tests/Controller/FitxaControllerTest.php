<?php

namespace Zerbikat\BackendBundle\Tests\Controller;


use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Response;


class FitxaControllerTest extends AbstractControllerTest
{
    public function testIndexAction()
    {
        $crawler = $this->client->request('GET', '/eu/fitxa/');

        $this->assertEquals(Response::HTTP_OK,$this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Fitxak")')->count());

    }
    public function testAddAction()
    {
        $crawler = $this->client->request('GET', '/eu/fitxa/');

        $this->assertEquals(Response::HTTP_OK,$this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Fitxak")')->count());
        $link = $crawler
            ->filter('a:contains(" Fitxa berria")') // find all buttons with the text "Add"
            ->eq(0) // select the first button in the list
            ->link() // and click it
        ;
        $crawler = $this->client->click($link);


        // NEW
        $this->assertEquals(Response::HTTP_OK,$this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("KODEA")')->count());

        $form = $crawler->filter('form[name=fitxanew]')->form();
        $form[ 'fitxanew[espedientekodea]' ] = "test Fitxa";
        $form[ 'fitxanew[deskribapenaeu]' ] = "testdeskribapenaeu";
        $form[ 'fitxanew[deskribapenaes]' ] = "testdeskribapenaes";
        $link = $crawler
            ->filter('a:contains(" Gorde")') // find all buttons with the text "Add"
            ->eq(0) // select the first button in the list
            ->link() // and click it
        ;

        $crawler = $this->client->submit($form);
        $this->assertEquals('Zerbikat\BackendBundle\Controller\FitxaController::newAction', $this->client->getRequest()->attributes->get('_controller'));
        $this->assertTrue($this->client->getResponse()->isRedirect());

       // $crawler = $this->client->followRedirect();


//        $redirectURL = $this->client->redirect;
//        $crawler = $this->client->request('GET', $redirectURL);
//
//        $this->assertEquals(Response::HTTP_OK,$this->client->getResponse()->getStatusCode());
//        $this->assertTrue($this->client->getResponse()->isSuccessful());
//        $this->assertEquals('Zerbikat\BackendBundle\Controller\FitxaController::editAction', $this->client->getRequest()->attributes->get('_controller'));
    }
    public function testShowAction()
    {
        $crawler = $this->client->request('GET', '/eu/fitxa/');

        $this->assertEquals(Response::HTTP_OK,$this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Fitxak")')->count());
        $link = $crawler
            ->filter('a:contains("testdeskribapenaeu")') // find all buttons with the text "Add"
            ->eq(0) // select the first button in the list
            ->link() // and click it
        ;
        $crawler = $this->client->click($link);
        $this->assertEquals('Zerbikat\BackendBundle\Controller\FitxaController::showAction', $this->client->getRequest()->attributes->get('_controller'));
    }
    public function testEditAction()
    {
        $crawler = $this->client->request('GET', '/eu/fitxa/');

        $this->assertEquals(Response::HTTP_OK,$this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Fitxak")')->count());
        $link = $crawler
            ->filter('a:contains("testdeskribapenaeu")') // find all buttons with the text "Add"
            ->eq(0) // select the first button in the list
            ->link() // and click it
        ;
        $crawler = $this->client->click($link);
        $link = $crawler
            ->filter('a:contains(" Aldatu")') // find all buttons with the text "Add"
            ->eq(0) // select the first button in the list
            ->link() // and click it
        ;

        $crawler = $this->client->click($link);
        $this->assertEquals('Zerbikat\BackendBundle\Controller\FitxaController::editAction', $this->client->getRequest()->attributes->get('_controller'));
        $form = $crawler->filter('form[name=fitxanew]')->form();
        $form[ 'fitxanew[espedientekodea]' ] = "test Fitxa0";
        $link = $crawler
            ->filter('a:contains(" Gorde")') // find all buttons with the text "Add"
            ->eq(0) // select the first button in the list
            ->link() // and click it
        ;

        $crawler = $this->client->submit($form);
    }
}
