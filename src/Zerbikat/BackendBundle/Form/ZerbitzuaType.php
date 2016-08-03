<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class ZerbitzuaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kodea',TextType::class, array(
                'label' => 'messages.kodea',
                'translation_domain' => 'messages',
            ))
            ->add('zerbitzuaeu',TextType::class, array(
                'label' => 'messages.zerbitzua',
                'translation_domain' => 'messages',
            ))
            ->add('zerbitzuaes',TextType::class, array(
                'label' => 'messages.zerbitzua',
                'translation_domain' => 'messages',
            ))
            ->add('erroaeu',TextType::class, array(
                'label' => 'messages.erroa',
                'translation_domain' => 'messages',
            ))
            ->add('erroaes',TextType::class, array(
                'label' => 'messages.erroa',
                'translation_domain' => 'messages',
            ))
//            ->add('espedientekudeaketa')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\Zerbitzua'
        ));
    }
}
