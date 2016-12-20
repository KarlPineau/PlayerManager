<?php

namespace DnDRules\LevelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LevelRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level',                  'integer',      array(  'required' => true))
            ->add('xpPoints',               'integer',      array(  'required' => true))
            ->add('classSkillModifier',     'integer',      array(  'required' => true))
            ->add('ofClassSkillModifier',   'number',       array(  'required' => true, 'scale' => 1))
            ->add('gift',                   'choice',       array(  'choices'   => array(true => 'oui', false => 'non'),
                                                                    'required'  => true,
                                                                    'empty_value' => 'Choisissez une option',
                                                                    'empty_data'  => false))
            ->add('abilityUp',              'choice',       array(  'choices'   => array(true => 'oui', false => 'non'),
                                                                    'required'  => true,
                                                                    'empty_value' => 'Choisissez une option',
                                                                    'empty_data'  => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\LevelBundle\Entity\Level'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_levelbundle_level_register';
    }
}
