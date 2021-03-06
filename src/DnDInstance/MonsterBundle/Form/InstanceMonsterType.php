<?php

namespace DnDInstance\MonsterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstanceMonsterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('monster',    'entity',   array(  'class' => 'DnDRulesMonsterBundle:Monster',
                                                    'property'    => 'name',
                                                    'expanded' => false,
                                                    'multiple' => false,
                                                    'required' => true,
                                                    'empty_value' => 'Monstre ...',
                                                    'empty_data'  => null,
                                                    'mapped' => false))
            ->add('weakNumber',  'integer',  array( 'required' => true,
                                                    'data' => 0,
                                                    'mapped' => false))
            ->add('strongNumber','integer',  array( 'required' => true,
                                                    'data' => 0,
                                                    'mapped' => false))
            ->add('defaultNumber','integer', array( 'required' => true,
                                                    'data' => 0,
                                                    'mapped' => false))
            ->add('randomNumber','integer',  array( 'required' => true,
                                                    'data' => 0,
                                                    'mapped' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndinstance_monster_monster_instance';
    }
}
