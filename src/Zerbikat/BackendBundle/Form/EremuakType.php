<?php

namespace Zerbikat\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EremuakType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oharraktext')
            ->add('oharraklabeleu')
            ->add('oharraklabeles')
            ->add('helburuatext')
            ->add('helburualabeleu')
            ->add('helburualabeles')
            ->add('ebazpensinpli')
            ->add('ebazpensinplilabeleu')
            ->add('ebazpensinplilabeles')
            ->add('arduraaitorpena')
            ->add('arduraaitorpenalabeleu')
            ->add('arduraaitorpenalabeles')
            ->add('aurreikusi')
            ->add('aurreikusilabeleu')
            ->add('aurreikusilabeles')
            ->add('arrunta')
            ->add('arruntalabeleu')
            ->add('arruntalabeles')
            ->add('isiltasunadmin')
            ->add('isiltasunadminlabeleu')
            ->add('isiltasunadminlabeles')
            ->add('norkeskatutext')
            ->add('norkeskatutable')
            ->add('norkeskatulabeleu')
            ->add('norkeskatulabeles')
            ->add('dokumentazioatext')
            ->add('dokumentazioatable')
            ->add('dokumentazioalabeleu')
            ->add('dokumentazioalabeles')
            ->add('kostuatext')
            ->add('kostuatable')
            ->add('kostualabeleu')
            ->add('kostualabeles')
            ->add('araudiatext')
            ->add('araudiatable')
            ->add('araudialabeleu')
            ->add('araudialabeles')
            ->add('prozeduratext')
            ->add('prozeduratable')
            ->add('prozeduralabeleu')
            ->add('prozeduralabeles')
            ->add('doklaguntext')
            ->add('doklaguntable')
            ->add('doklagunlabeleu')
            ->add('doklagunlabeles')
            ->add('datuenbabesatext')
            ->add('datuenbabesatable')
            ->add('datuenbabesalabeleu')
            ->add('datuenbabesalabeles')
            ->add('azpisailatable')
            ->add('azpisailalabeleu')
            ->add('azpisailalabeles')
            ->add('norkebatzitext')
            ->add('norkebatzitable')
            ->add('norkebatzilabeleu')
            ->add('norkebatzilabeles')
            ->add('besteak1text')
            ->add('besteak1table')
            ->add('besteak1labeleu')
            ->add('besteak1labeles')
            ->add('besteak2text')
            ->add('besteak2table')
            ->add('besteak2labeleu')
            ->add('besteak2labeles')
            ->add('besteak3text')
            ->add('besteak3table')
            ->add('besteak3labeleu')
            ->add('besteak3labeles')
            ->add('kanalatext')
            ->add('kanalatable')
            ->add('kanalalabeleu')
            ->add('kanalalabeles')
            ->add('epealabeleu')
            ->add('epealabeles')
            ->add('doanlabeleu')
            ->add('doanlabeles')
            ->add('udala')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Zerbikat\BackendBundle\Entity\Eremuak'
        ));
    }
}
