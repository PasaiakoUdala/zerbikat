<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FitxafamiliaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ordena')
            ->add('familia',
                EntityType::class,
                array (
                    'class'       => 'BackendBundle:Familia',
                    'required'    => false,
                    'multiple'    => 'multiple',
                    'placeholder' => 'Aukeratu kostu taulak',

                )
            )
            ->add('fitxa')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\Fitxafamilia'
        ));
    }
}
