<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class OrdenantzaparrafoaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ordena')
//            ->add('testuaeu')
            ->add('testuaeu',CKEditorType::class, array(
                'config' => array()))
            ->add('testuaes',CKEditorType::class, array(
                'config' => array()))
//            ->add('testuaes')
//            ->add('createdAt', 'datetime')
//            ->add('updatedAt', 'datetime')
            ->add('udala')
            ->add('ordenantza')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\Ordenantzaparrafoa'
        ));
    }
}
