<?php

    namespace Zerbikat\BackendBundle\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
    use Ivory\CKEditorBundle\Form\Type\CKEditorType;
//use Zerbikat\BackendBundle\Entity\FitxaProzedura;
    use Symfony\Component\Form\Extension\Core\Type\CollectionType;

    class FitxanewType extends AbstractType
    {

        /**
         * @param FormBuilderInterface $builder
         * @param array $options
         */
        public function buildForm ( FormBuilderInterface $builder, array $options )
        {
            $builder
                ->add( 'espedientekodea' )
                ->add( 'deskribapenaeu' )
                ->add( 'deskribapenaes' )

            ;
        }

        /**
         * @param OptionsResolver $resolver
         */
        public function configureOptions ( OptionsResolver $resolver )
        {
            $resolver->setDefaults(
                array (
                    'data_class' => 'Zerbikat\BackendBundle\Entity\Fitxa'
                )
            );
        }
    }
