<?php

namespace DnDRules\RaceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaceRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',               'text',     array('required' => true))
            ->add('description',        'textarea', array('required' => false))
            ->add('size',  'entity',    array('class' => 'DnDRulesSizeBundle:Size',
                                                          'property'    => 'name',
                                                          'required' => false,
                                                          'empty_value' => 'Taille',
                                                          'empty_data'  => null))
            ->add('hpModifier',         'integer',  array('required' => true))
            ->add('speed',              'number',   array('required' => true, 'scale' => 1))
            ->add('skillModifier',      'integer',  array('required' => true))
            ->add('predilectionClass',  'entity',   array('class' => 'DnDRulesClassDnDBundle:ClassDnD',
                                                          'property'    => 'name',
                                                          'required' => false,
                                                          'empty_value' => 'Classes de Prédilection',
                                                          'empty_data'  => null))
            ->add('languages',          'entity',   array('class' => 'DnDRulesLanguageBundle:Language',
                                                          'property'    => 'name',
                                                          'expanded' => false,
                                                          'multiple' => true,
                                                          'required' => false,
                                                          'empty_value' => 'Langues',
                                                          'empty_data'  => null))
            ->add('strength',           'integer',  array('required' => true, 'mapped' => false))
            ->add('dexterity',          'integer',  array('required' => true, 'mapped' => false))
            ->add('constitution',       'integer',  array('required' => true, 'mapped' => false))
            ->add('intelligence',       'integer',  array('required' => true, 'mapped' => false))
            ->add('wisdom',             'integer',  array('required' => true, 'mapped' => false))
            ->add('charisma',           'integer',  array('required' => true, 'mapped' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\RaceBundle\Entity\Race'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_racebundle_race_register';
    }
}
