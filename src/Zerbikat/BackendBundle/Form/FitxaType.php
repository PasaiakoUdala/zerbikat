<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FitxaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('espedientekodea')
            ->add('deskribapenaeu')
            ->add('deskribapenaes')
            ->add('helburuaeu')
            ->add('helburuaes')
            ->add('norkeu')
            ->add('norkes')
            ->add('dokumentazioaeu')
            ->add('dokumentazioaes')
            ->add('nolabertan')
            ->add('nolainternet')
            ->add('nolatelefono')
            ->add('nolapostela')
            ->add('nolaposta')
            ->add('nolabesteakeu')
            ->add('nolabesteakes')
            ->add('kostuaeu')
            ->add('kostuaes')
            ->add('ebazpensinpli')
            ->add('arduraaitorpena')
            ->add('isiltasunadmin')
            ->add('araudiaeu')
            ->add('araudiaes')
            ->add('prozeduraeu')
            ->add('prozeduraes')
            ->add('tramiteakeu')
            ->add('tramiteakes')
            ->add('doklaguneu')
            ->add('doklagunes')
            ->add('oharrakeu')
            ->add('oharrakes')
            ->add('publikoa')
            ->add('kontsultak')
            ->add('parametroa')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('besteak1eu')
            ->add('besteak1es')
            ->add('bestea2keu')
            ->add('besteak2es')
            ->add('besteak3eu')
            ->add('besteak3es')
            ->add('udala')
            ->add('norkebatzi')
            ->add('zerbitzua')
            ->add('datuenbabesa')
            ->add('azpisaila')
            ->add('aurreikusi')
            ->add('arrunta')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\Fitxa'
        ));
    }
}
