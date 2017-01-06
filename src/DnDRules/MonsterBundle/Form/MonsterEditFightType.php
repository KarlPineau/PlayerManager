<?php

namespace DnDRules\MonsterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PM\HomeBundle\Form\DiceFormType;

class MonsterEditFightType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('powerfullFactor',    'integer',  array(  'required' => false))
            ->add('initiative',         'integer',  array(  'required' => true))
            ->add('bab',                'integer',  array(  'required' => true))
            ->add('bfb',                'integer',  array(  'required' => true))
            ->add('ac',                 'integer',  array(  'required' => true))
            ->add('touchAC',            'integer',  array(  'required' => false))
            ->add('ffAC',               'integer',  array(  'required' => false))
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
        return 'dndrules_monsterbundle_monster_edit_fight';
    }
}
