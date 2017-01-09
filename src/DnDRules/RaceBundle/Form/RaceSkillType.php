<?php

namespace DnDRules\RaceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaceSkillType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('skill',      'entity', array('class' => 'DnDRulesSkillBundle:Skill',
                                                'property'    => 'name',
                                                'empty_value' => 'Sélectionnez une compétence ...',
                                                'required' => true,
                                                'label' => 'Compétence'))
            ->add('value',      'integer',      array('required' => true, 'label' => 'Modificateur'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\RaceBundle\Entity\RaceSkill'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_race_race_skill';
    }
}
