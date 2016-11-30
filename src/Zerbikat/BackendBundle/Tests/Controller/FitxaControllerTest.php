<?php

namespace Zerbikat\BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class FitxaControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSecuredHello()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/eu/fitxa/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Fitxak")')->count());



        $link = $crawler->filter('a:contains("Fitxa berria")')->eq(1)->link();

        $crawler = $client->click($link);


//        $client = static::createClient();
//        $crawler = $this->client->request('GET', '/eu/fitxa/new');
//        $crawler = $client->click($crawler->selectLink('Fitxa berria')->link());
//
//        $link = $this->client->selectLink(' Fitxa berria')->link();
//        $crawler = $client->click($link);
//
//        $form = $crawler->selectButton('validate')->form();
//        $crawler = $client->submit($form, array('name' => 'Fabien'));
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = 'main';
        $token = new UsernamePasswordToken('pasaia', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
