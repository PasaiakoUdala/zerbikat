<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AzpisailaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kodea')
            ->add('azpisailaeu')
            ->add('azpisailaes')
            ->add('arduraduna')
            ->add('arduradunahaz')
            ->add('email')
            ->add('telefonoa')
            ->add('fax')
            ->add('kaleZbkia')
            ->add('hizkia')
            ->add('ordutegia')
            ->add('udala')
            ->add('saila')
            ->add('kalea')
            ->add('eraikina')
            ->add('barrutia')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\Azpisaila'
        ));
    }
}
