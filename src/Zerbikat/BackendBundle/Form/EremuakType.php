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
            ->add('oharraktext',CheckboxType::class, array(
                'label'    => 'messages.oharraktext',
                'translation_domain' => 'messages',
                ))
            ->add('oharraklabeleu',TextType::class, array(
                'label' => 'messages.oharraklabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('oharraklabeles',TextType::class, array(
                'label' => 'messages.oharraklabeles',
                'translation_domain' => 'messages',
            ))
            ->add('helburuatext',CheckboxType::class, array(
                'label'    => 'messages.helburuatext',
                'translation_domain' => 'messages',
            ))
            ->add('helburualabeleu',TextType::class, array(
                'label' => 'messages.helburualabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('helburualabeles',TextType::class, array(
                'label' => 'messages.helburualabeles',
                'translation_domain' => 'messages',
            ))
            ->add('ebazpensinpli',CheckboxType::class, array(
                'label'    => 'messages.ebazpensinpli',
                'translation_domain' => 'messages',
            ))
            ->add('ebazpensinplilabeleu',TextType::class, array(
                'label' => 'messages.ebazpensinplilabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('ebazpensinplilabeles',TextType::class, array(
                'label' => 'messages.ebazpensinplilabeles',
                'translation_domain' => 'messages',
            ))
            ->add('arduraaitorpena',CheckboxType::class, array(
                'label'    => 'messages.arduraaitorpena',
                'translation_domain' => 'messages',
            ))
            ->add('arduraaitorpenalabeleu',TextType::class, array(
                'label' => 'messages.arduraaitorpenalabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('arduraaitorpenalabeles',TextType::class, array(
                'label' => 'messages.arduraaitorpenalabeles',
                'translation_domain' => 'messages',
            ))
            ->add('aurreikusi',CheckboxType::class, array(
                'label'    => 'messages.aurreikusi',
                'translation_domain' => 'messages',
            ))
            ->add('aurreikusilabeleu',TextType::class, array(
                'label' => 'messages.aurreikusilabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('aurreikusilabeles',TextType::class, array(
                'label' => 'messages.aurreikusilabeles',
                'translation_domain' => 'messages',
            ))
            ->add('arrunta',CheckboxType::class, array(
                'label'    => 'messages.arrunta',
                'translation_domain' => 'messages',
            ))
            ->add('arruntalabeleu',TextType::class, array(
                'label' => 'messages.arruntalabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('arruntalabeles',TextType::class, array(
                'label' => 'messages.arruntalabeles',
                'translation_domain' => 'messages',
            ))
            ->add('isiltasunadmin',CheckboxType::class, array(
                'label'    => 'messages.isiltasunadmin',
                'translation_domain' => 'messages',
            ))
            ->add('isiltasunadminlabeleu',TextType::class, array(
                'label' => 'messages.isiltasunadminlabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('isiltasunadminlabeles',TextType::class, array(
                'label' => 'messages.isiltasunadminlabeles',
                'translation_domain' => 'messages',
            ))
            ->add('norkeskatutext',CheckboxType::class, array(
                'label'    => 'messages.norkeskatutext',
                'translation_domain' => 'messages',
            ))
            ->add('norkeskatutable',CheckboxType::class, array(
                'label'    => 'messages.norkeskatutable',
                'translation_domain' => 'messages',
            ))
            ->add('norkeskatulabeleu',TextType::class, array(
                'label' => 'messages.norkeskatulabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('norkeskatulabeles',TextType::class, array(
                'label' => 'messages.norkeskatulabeles',
                'translation_domain' => 'messages',
            ))
            ->add('dokumentazioatext',CheckboxType::class, array(
                'label'    => 'messages.dokumentazioatext',
                'translation_domain' => 'messages',
            ))
            ->add('dokumentazioatable',CheckboxType::class, array(
                'label'    => 'messages.dokumentazioatable',
                'translation_domain' => 'messages',
            ))
            ->add('dokumentazioalabeleu',TextType::class, array(
                'label' => 'messages.dokumentazioalabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('dokumentazioalabeles',TextType::class, array(
                'label' => 'messages.dokumentazioalabeles',
                'translation_domain' => 'messages',
            ))
            ->add('kostuatext',CheckboxType::class, array(
                'label'    => 'messages.kostuatext',
                'translation_domain' => 'messages',
            ))
            ->add('kostuatable',CheckboxType::class, array(
                'label'    => 'messages.kostuatable',
                'translation_domain' => 'messages',
            ))
            ->add('kostualabeleu',TextType::class, array(
                'label' => 'messages.kostualabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('kostualabeles',TextType::class, array(
                'label' => 'messages.kostualabeles',
                'translation_domain' => 'messages',
            ))
            ->add('araudiatext',CheckboxType::class, array(
                'label'    => 'messages.araudiatext',
                'translation_domain' => 'messages',
            ))
            ->add('araudiatable',CheckboxType::class, array(
                'label'    => 'messages.araudiatable',
                'translation_domain' => 'messages',
            ))
            ->add('araudialabeleu',TextType::class, array(
                'label' => 'messages.araudialabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('araudialabeles',TextType::class, array(
                'label' => 'messages.araudialabeles',
                'translation_domain' => 'messages',
            ))
            ->add('prozeduratext',CheckboxType::class, array(
                'label'    => 'messages.prozeduratext',
                'translation_domain' => 'messages',
            ))
            ->add('prozeduratable',CheckboxType::class, array(
                'label'    => 'messages.prozeduratable',
                'translation_domain' => 'messages',
            ))
            ->add('prozeduralabeleu',TextType::class, array(
                'label' => 'messages.prozeduralabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('prozeduralabeles',TextType::class, array(
                'label' => 'messages.prozeduralabeles',
                'translation_domain' => 'messages',
            ))
            ->add('doklaguntext',CheckboxType::class, array(
                'label'    => 'messages.doklaguntext',
                'translation_domain' => 'messages',
            ))
            ->add('doklaguntable',CheckboxType::class, array(
                'label'    => 'messages.doklaguntable',
                'translation_domain' => 'messages',
            ))
            ->add('doklagunlabeleu',TextType::class, array(
                'label' => 'messages.doklagunlabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('doklagunlabeles',TextType::class, array(
                'label' => 'messages.doklagunlabeles',
                'translation_domain' => 'messages',
            ))
            ->add('datuenbabesatext',CheckboxType::class, array(
                'label'    => 'messages.datuenbabesatext',
                'translation_domain' => 'messages',
            ))
            ->add('datuenbabesatable',CheckboxType::class, array(
                'label'    => 'messages.datuenbabesatable',
                'translation_domain' => 'messages',
            ))
            ->add('datuenbabesalabeleu',TextType::class, array(
                'label' => 'messages.datuenbabesalabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('datuenbabesalabeles',TextType::class, array(
                'label' => 'messages.datuenbabesalabeles',
                'translation_domain' => 'messages',
            ))
            ->add('azpisailatable',CheckboxType::class, array(
                'label'    => 'messages.azpisailatable',
                'translation_domain' => 'messages',
            ))
            ->add('azpisailalabeleu',TextType::class, array(
                'label' => 'messages.azpisailalabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('azpisailalabeles',TextType::class, array(
                'label' => 'messages.azpisailalabeles',
                'translation_domain' => 'messages',
            ))
            ->add('norkebatzitext',CheckboxType::class, array(
                'label'    => 'messages.norkebatzitext',
                'translation_domain' => 'messages',
            ))
            ->add('norkebatzitable',CheckboxType::class, array(
                'label'    => 'messages.norkebatzitable',
                'translation_domain' => 'messages',
            ))
            ->add('norkebatzilabeleu',TextType::class, array(
                'label' => 'messages.norkebatzilabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('norkebatzilabeles',TextType::class, array(
                'label' => 'messages.norkebatzilabeles',
                'translation_domain' => 'messages',
            ))
            ->add('besteak1text',CheckboxType::class, array(
                'label'    => 'messages.besteak1text',
                'translation_domain' => 'messages',
            ))
            ->add('besteak1table',CheckboxType::class, array(
                'label'    => 'messages.besteak1table',
                'translation_domain' => 'messages',
            ))
            ->add('besteak1labeleu',TextType::class, array(
                'label' => 'messages.besteak1labeleu',
                'translation_domain' => 'messages',
            ))
            ->add('besteak1labeles',TextType::class, array(
                'label' => 'messages.besteak1labeles',
                'translation_domain' => 'messages',
            ))
            ->add('besteak2text',CheckboxType::class, array(
                'label'    => 'messages.besteak2text',
                'translation_domain' => 'messages',
            ))
            ->add('besteak2table',CheckboxType::class, array(
                'label'    => 'messages.besteak2table',
                'translation_domain' => 'messages',
            ))
            ->add('besteak2labeleu',TextType::class, array(
                'label' => 'messages.besteak2labeleu',
                'translation_domain' => 'messages',
            ))
            ->add('besteak2labeles',TextType::class, array(
                'label' => 'messages.besteak2labeles',
                'translation_domain' => 'messages',
            ))
            ->add('besteak3text',CheckboxType::class, array(
                'label'    => 'messages.besteak3text',
                'translation_domain' => 'messages',
            ))
            ->add('besteak3table',CheckboxType::class, array(
                'label'    => 'messages.besteak3table',
                'translation_domain' => 'messages',
            ))
            ->add('besteak3labeleu',TextType::class, array(
                'label' => 'messages.besteak3labeleu',
                'translation_domain' => 'messages',
            ))
            ->add('besteak3labeles',TextType::class, array(
                'label' => 'messages.besteak3labeles',
                'translation_domain' => 'messages',
            ))
            ->add('kanalatext',CheckboxType::class, array(
                'label'    => 'messages.kanalatext',
                'translation_domain' => 'messages',
            ))
            ->add('kanalatable',CheckboxType::class, array(
                'label'    => 'messages.kanalatable',
                'translation_domain' => 'messages',
            ))
            ->add('kanalalabeleu',TextType::class, array(
                'label' => 'messages.kanalalabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('kanalalabeles',TextType::class, array(
                'label' => 'messages.kanalalabeles',
                'translation_domain' => 'messages',
            ))
            ->add('epealabeleu',TextType::class, array(
                'label' => 'messages.epealabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('epealabeles',TextType::class, array(
                'label' => 'messages.epealabeles',
                'translation_domain' => 'messages',
            ))
            ->add('doanlabeleu',TextType::class, array(
                'label' => 'messages.doanlabeleu',
                'translation_domain' => 'messages',
            ))
            ->add('doanlabeles',TextType::class, array(
                'label' => 'messages.doanlabeles',
                'translation_domain' => 'messages',
            ))
            ->add('udala',TextType::class, array(
                'label'    => 'messages.udala',
                'translation_domain' => 'messages',
            ))
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
