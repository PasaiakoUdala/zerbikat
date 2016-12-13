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
        $form[ 'fitxanew[deskribapenaeu]' ] = "test Fitxa deskribapenaeu";
        $form[ 'fitxanew[deskribapenaes]' ] = "test Fitxa deskribapenaes";
        $link = $crawler
            ->filter('a:contains(" Gorde")') // find all buttons with the text "Add"
            ->eq(0) // select the first button in the list
            ->link() // and click it
        ;

        $crawler = $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->assertTrue($this->client->getResponse()->isSuccessful(), 'response status is 2xx');

//        $this->assertContains('Your data has been saved!', $response->getContent());
    }
}
