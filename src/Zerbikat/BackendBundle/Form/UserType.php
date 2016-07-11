<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class UserType extends AbstractType
//class UserType extends BaseType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('username')
            ->add('udala')
            ->add('azpisaila')
            ->add('enabled')
            ->add('email')
            ->add('roles')
            ->add('password')

//            ->add('roles', CollectionType::class, array(
//                'entry_type'   => ChoiceType::class,
////                'multiple'=>'multiple',
//                'entry_options'  => array(
//                    'choices'  => array(
//                        'ROLE_USER' => 'a:0:{}',
//                        'ROLE_KUDEAKETA' => 'a:1:{i:0;s:14:"ROLE_KUDEAKETA";}',
//                        'ROLE_ADMIN'     => 'a:1:{i:0;s:10:"ROLE_ADMIN";}',
//                        'ROLE_SUPER_ADMIN'    => 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}'
//            ),
//        )))



        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\User'
        ));
    }
}
