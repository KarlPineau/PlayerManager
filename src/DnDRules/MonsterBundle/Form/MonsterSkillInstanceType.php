<?php

namespace DnDRules\MonsterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonsterSkillInstanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ranks',          'integer',      array('required' => true,
                                                          'scale' => 2,
                                                          'label' => 'Degré de maitrise',
                                                          'attr' => array('class' => 'form-control')))
            ->add('skill',          'entity',       array(  'class' => 'DnDRulesSkillBundle:Skill',
                                                            'property'    => 'name',
                                                            'expanded' => false,
                                                            'multiple' => false,
                                                            'required' => true,
                                                            'empty_value' => 'Compétence',
                                                            'empty_data'  => null,
                                                            'label' => 'Compétences',
                                                            'attr' => array('class' => 'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\MonsterBundle\Entity\MonsterSkillInstance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_monsterbundle_monsterskillinstance';
    }
}
