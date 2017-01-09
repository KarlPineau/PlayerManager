<?php

namespace Game\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GameEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',           'text',     array(  'required' => true))
            ->add('synopsis',       'textarea', array(  'required' => true))
            ->add('importChara',    'choice',   array(  'required' => true,
                                                        'choices'  => array(true => 'Oui', false => 'Non'),
                                                        'multiple' => false,
                                                        'expanded' => true))
            ->add('lvlMin',         'integer',  array(  'required' => false))
            ->add('lvlMax',         'integer',  array(  'required' => false))
            ->add('wealthFactor',   'integer',  array(  'required' => false))
            ->add('active',         'choice',   array(  'required' => true,
                                                        'choices'  => array(true => 'Oui', false => 'Non'),
                                                        'multiple' => false,
                                                        'expanded' => true))
            ->add('gameMasters',    'entity',   array(  'class' => 'CASUserBundle:User',
                                                        'property'    => 'username',
                                                        'expanded' => false,
                                                        'multiple' => true,
                                                        'required' => false,
                                                        'empty_value' => 'Utilisateur',
                                                        'empty_data'  => null))
            ->add('openRaces',      'entity',   array(  'class' => 'DnDRulesRaceBundle:Race',
                                                        'property'    => 'name',
                                                        'expanded' => false,
                                                        'multiple' => true,
                                                        'required' => false,
                                                        'empty_value' => 'Races',
                                                        'empty_data'  => null))
            ->add('openClasses',    'entity',   array(  'class' => 'DnDRulesClassDnDBundle:ClassDnD',
                                                        'property'    => 'name',
                                                        'expanded' => false,
                                                        'multiple' => true,
                                                        'required' => false,
                                                        'empty_value' => 'Classes',
                                                        'empty_data'  => null))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Game\GameBundle\Entity\Game'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'game_game_game_edit';
    }
}
