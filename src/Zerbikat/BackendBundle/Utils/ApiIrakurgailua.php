<?php
namespace Zerbikat\BackendBundle\Utils;
//use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
//use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use GuzzleHttp;

class ApiIrakurgailua extends LazyChoiceList
{
    protected function loadChoiceList()
    {
    //fetch and process api data
        $client = new GuzzleHttp\Client();
        $res = $client->request( 'GET', 'http://zergaordenantzak.dev/app_dev.php/api/azpiatalak.json' );

//        dump ($res);
//        return new ChoiceList($choices, $labels);

    }
}