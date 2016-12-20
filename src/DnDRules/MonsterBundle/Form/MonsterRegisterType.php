<?php

namespace DnDRules\MonsterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PM\HomeBundle\Form\DiceFormType;

class MonsterRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',               'text',     array(  'required' => true))
            ->add('description',        'ckeditor', array(  'required' => false))
            ->add('socialOrganisation', 'ckeditor', array(  'required' => false))
            ->add('powerfullFactor',    'integer',  array(  'required' => false))
            ->add('initiative',         'integer',  array(  'required' => true))
            ->add('hpForm',             'collection',array( 'type' => new DiceFormType(),
                                                            'allow_add'    => true,
                                                            'allow_delete' => true,
                                                            'required' => false))
            ->add('hpAverage',          'integer',  array(  'required' => false))
            ->add('grappleModifier',    'integer',  array(  'required' => true))
            ->add('ac',                 'integer',  array(  'required' => true))
            ->add('touchAC',            'integer',  array(  'required' => false))
            ->add('ffAC',               'integer',  array(  'required' => false))
            ->add('speed',              'number',   array(  'required' => false, 'scale' => 1))
            ->add('spaceOccupied',      'number',   array(  'required' => false, 'scale' => 1))
            ->add('areaLying',          'number',   array(  'required' => false, 'scale' => 1))
            ->add('alignment',          'entity',   array(  'class' => 'DnDRulesAlignmentBundle:Alignment',
                                                            'property' => 'name',
                                                            'required' => false,
                                                            'empty_value' => 'Choisissez un alignement',
                                                            'empty_data'  => null))
            ->add('environment',        'entity',   array(  'class' => 'DnDRulesMonsterBundle:Environment',
                                                            'property' => 'name',
                                                            'required' => false,
                                                            'empty_value' => 'Choisissez un environnement',
                                                            'empty_data'  => null))
            ->add('languages',          'entity',   array(  'class' => 'DnDRulesLanguageBundle:Language',
                                                            'property'    => 'name',
                                                            'expanded' => false,
                                                            'multiple' => true,
                                                            'required' => false,
                                                            'empty_value' => 'Langues',
                                                            'empty_data'  => null))
            ->add('gifts',              'entity',   array(  'class' => 'DnDRulesGiftBundle:Gift',
                                                            'property'    => 'name',
                                                            'expanded' => false,
                                                            'multiple' => true,
                                                            'required' => false,
                                                            'empty_value' => 'Dons',
                                                            'empty_data'  => null))
            ->add('speedSpecialInstances','collection',array( 'type' => new SpeedSpecialInstanceType(),
                                                            'allow_add'    => true,
                                                            'allow_delete' => true,
                                                            'required' => false))
            ->add('skillInstances',     'collection',array( 'type' => new MonsterSkillInstanceType(),
                                                            'allow_add'    => true,
                                                            'allow_delete' => true,
                                                            'required' => false))
            ->add('abilityInstances',   'collection',array( 'type' => new MonsterAbilityInstanceType(),
                                                            'allow_add'    => true,
                                                            'allow_delete' => true,
                                                            'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\MonsterBundle\Entity\Monster'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_monsterbundle_monster_register';
    }
}
