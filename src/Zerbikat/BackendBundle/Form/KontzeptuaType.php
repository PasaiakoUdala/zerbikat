<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KontzeptuaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kodea')
            ->add('kontzeptuaeu')
            ->add('kontzeptuaes')
            ->add('kopurua')
            ->add('unitatea')
//            ->add('createdAt', 'datetime')
//            ->add('updatedAt', 'datetime')
            ->add('udala')
            ->add('kontzeptumota')
            ->add('baldintza')
            ->add('azpiatala')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\Kontzeptua'
        ));
    }
}
