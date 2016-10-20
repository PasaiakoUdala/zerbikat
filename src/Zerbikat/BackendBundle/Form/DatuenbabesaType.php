<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatuenbabesaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('izenaeu')
            ->add('izenaes')
            ->add('xedeaeu')
            ->add('xedeaes')
            ->add('maila')
            ->add('kodea')
            ->add('lagapenakeu')
            ->add('lagapenakes')
            ->add('udala')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\Datuenbabesa'
        ));
    }
}
