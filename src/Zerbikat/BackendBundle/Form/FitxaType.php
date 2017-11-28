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

    class FitxaType extends AbstractType
    {

        /**
         * @param FormBuilderInterface $builder
         * @param array $options
         */
        public function buildForm ( FormBuilderInterface $builder, array $options )
        {
            $user = $options['user'];
            $api_url = $options[ 'api_url' ];

            $builder
                ->add( 'espedientekodea' )
                ->add( 'expedientes' )
                ->add( 'deskribapenaeu' )
                ->add( 'deskribapenaes' )
                ->add(
                    'helburuaeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'helburuaes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'norkeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'norkes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'dokumentazioaeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'dokumentazioaes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'kostuaeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'kostuaes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add( 'ebazpensinpli' )
                ->add( 'arduraaitorpena' )
                ->add( 'isiltasunadmin' )
                ->add(
                    'araudiaeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'araudiaes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'prozeduraeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'prozeduraes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'doklaguneu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'doklagunes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'oharrakeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'oharrakes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'jarraibideakeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'jarraibideakes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add( 'publikoa' )
                ->add( 'hitzarmena' )
                ->add( 'kontsultak' )
                ->add( 'parametroa' )
                ->add( 'createdAt', DatetimeType::class, array ('widget' => 'single_text') )
                ->add( 'updatedAt', DatetimeType::class, array ('widget' => 'single_text') )
                ->add(
                    'besteak1eu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'besteak1es',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'besteak2eu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'besteak2es',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'besteak3eu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'besteak3es',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'datuenbabesaeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'datuenbabesaes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'norkonartueu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'norkonartues',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'kanalaeu',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add(
                    'kanalaes',
                    CKEditorType::class,
                    array (
                        'config' => array (),
                    )
                )
                ->add( 'udala' )
                ->add( 'norkebatzi' )
                ->add( 'zerbitzua' )
                ->add( 'datuenbabesa' )
                ->add( 'azpisaila' )
                ->add( 'aurreikusi' )
                ->add( 'arrunta' )
                ->add(
                    'dokumentazioak',
                    EntityType::class,
                    array (
                        'class'       => 'BackendBundle:Dokumentazioa',
                        'required'    => false,
                        'multiple'    => 'multiple',
                        'placeholder' => 'Aukeratu dokumentuak',
                        'group_by'    => 'dokumentumota',
                    )
                )
                ->add(
                    'etiketak',
                    EntityType::class,
                    array (
                        'class'       => 'BackendBundle:Etiketa',
                        'required'    => false,
                        'multiple'    => 'multiple',
                        'placeholder' => 'Aukeratu etiketak',
                        'empty_data'  => null,
                    )
                )
                ->add(
                    'kanalak',
                    EntityType::class,
                    array (
                        'class'       => 'BackendBundle:Kanala',
                        'required'    => false,
                        'multiple'    => 'multiple',
                        'placeholder' => 'Aukeratu kanalak',
                        'group_by'    => 'kanalmota',
                    )
                )
                ->add(
                    'besteak1ak',
                    EntityType::class,
                    array (
                        'class'       => 'BackendBundle:Besteak1',
                        'required'    => false,
                        'multiple'    => 'multiple',
                        'placeholder' => 'Aukeratu besteak1',
                    )
                )
                ->add(
                    'besteak2ak',
                    EntityType::class,
                    array (
                        'class'       => 'BackendBundle:Besteak2',
                        'required'    => false,
                        'multiple'    => 'multiple',
                        'placeholder' => 'Aukeratu besteak2',
                    )
                )
                ->add(
                    'besteak3ak',
                    EntityType::class,
                    array (
                        'class'       => 'BackendBundle:Besteak3',
                        'required'    => false,
                        'multiple'    => 'multiple',
                        'placeholder' => 'Aukeratu besteak3',
                    )
                )
                ->add(
                    'norkeskatuak',
                    EntityType::class,
                    array (
                        'class'       => 'BackendBundle:Norkeskatu',
                        'required'    => false,
                        'multiple'    => 'multiple',
                        'placeholder' => 'Aukeratu nork eska dezakeen',
                    )
                )
                ->add(
                    'doklagunak',
                    EntityType::class,
                    array (
                        'class'       => 'BackendBundle:Doklagun',
                        'required'    => false,
                        'multiple'    => 'multiple',
                        'placeholder' => 'Aukeratu dokumentazio lagungarria',
                    )
                )
                ->add(
                    'azpiatalak',
                    EntityType::class,
                    array (
                        'class'       => 'BackendBundle:Azpiatala',
                        'required'    => false,
                        'multiple'    => 'multiple',
                        'placeholder' => 'Aukeratu kostu taulak',

                    )
                )
                ->add(
                    'prozedurak',
                    CollectionType::class,
                    array (
                        'entry_type'   => FitxaProzeduraType::class,
                        'allow_add'    => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    )
                )
                ->add(
                    'araudiak',
                    CollectionType::class,
                    array (
                        'entry_type'   => FitxaAraudiaType::class,
                        'allow_add'    => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                    )
                )
                ->add(
                    'kostuak',
                    CollectionType::class,
                    array (
                        'entry_type'   => FitxaKostuaType::class,
                        'entry_options'  => array(
                            'udala' => $user->getUdala()->getId(),
                            'api_url' => $api_url
                        ),
                        'allow_add'    => true,
                        'allow_delete' => true,
                        'by_reference' => false
                    )
                )

            ;
        }

        /**
         * @param OptionsResolver $resolver
         */
        public function configureOptions ( OptionsResolver $resolver )
        {
            $resolver->setDefaults(
                array (
                    'data_class' => 'Zerbikat\BackendBundle\Entity\Fitxa',
                    'user' => null,
                    'api_url' => null
                )
            );
        }
    }
