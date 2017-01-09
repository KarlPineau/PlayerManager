<?php

namespace DnDRules\RaceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaceLevelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level',                      'entity',    array( 'class' => 'DnDRulesLevelBundle:Level',
                                                                    'property'    => 'level',
                                                                    'required' => false,
                                                                    'empty_value' => 'Niveau',
                                                                    'empty_data'  => null,
                                                                    'label' => 'Niveau'))
            ->add('gift',                       'choice',    array( 'choices'   => array(true => 'oui', false => 'non'),
                                                                    'required'  => true,
                                                                    'empty_value' => 'Choisissez une option',
                                                                    'empty_data'  => false,
                                                                    'label' => 'Don supp.'))
            ->add('additionalSkillPoints',      'integer',   array( 'required' => true,
                                                                    'label' => 'Points de compétence supp.'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\RaceBundle\Entity\RaceLevel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_race_race_level';
    }
}
