<?php

namespace Zerbikat\BackendBundle\Form;

use JMS\SerializerBundle\JMSSerializerBundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use GuzzleHttp;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class FitxaKostuaType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $client = new GuzzleHttp\Client();
        $proba = $client->request( 'GET', 'http://zergaordenantzak.dev/app_dev.php/api/azpiatalak.json' );
        $valftp = (string)$proba->getBody();
        $array = json_decode($valftp, true);

        $resp=array();
        foreach ($array as $a)
        {
            $resp[$a['izenburuaeu']] = $a['id'];
        }

        $builder
            ->add('udala')
            ->add('fitxa')
            ->add('kostua', ChoiceType::class, array(
//                'choice_list' => new \Zerbikat\BackendBundle\Utils\ApiIrakurgailua(),
//                'choices' => array(
//                    'taula1' => '1',
//                    'taula2' => '2',
//                    'taula3'   => '3',
//                    'taula4' => '4'
//                )
                'choices' => $resp
                )

            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\FitxaKostua'
        ));
    }
}
