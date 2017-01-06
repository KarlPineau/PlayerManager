<?php

namespace DnDRules\ClassDnDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassDnDRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',           'text',     array('required' => true))
            ->add('description',    'textarea', array('required' => false))
            ->add('skills',         'entity',   array('class' => 'DnDRulesSkillBundle:Skill',
                                                      'property'    => 'name',
                                                      'expanded' => false,
                                                      'multiple' => true,
                                                      'required' => false,
                                                      'empty_value' => 'Compétences de Classe',
                                                      'empty_data'  => null))
            ->add('allowArmorType',         'entity',   array('class' => 'DnDRulesArmorBundle:ArmorType',
                                                    'property'    => 'name',
                                                    'expanded' => false,
                                                    'multiple' => true,
                                                    'required' => false,
                                                    'empty_value' => 'Types d\'armure maitrisés',
                                                    'empty_data'  => null))
            ->add('allowWeaponType',         'entity',   array('class' => 'DnDRulesWeaponBundle:WeaponType',
                                                    'property'    => 'name',
                                                    'expanded' => false,
                                                    'multiple' => true,
                                                    'required' => false,
                                                    'empty_value' => 'Types d\'arme maitrisés',
                                                    'empty_data'  => null))
            ->add('diceHealth',     'entity',   array('class' => 'PMHomeBundle:DiceType',
                                                    'property'    => 'dice',
                                                    'expanded' => false,
                                                    'multiple' => false,
                                                    'required' => false,
                                                    'empty_value' => 'Dé de vie',
                                                    'empty_data'  => null))
            ->add('pointsSkillByLevel',   'integer', array('required' => false))
            ->add('pointsSkillFirstLevel','integer', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\ClassDnDBundle\Entity\ClassDnD'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_classdndbundle_classDnD_register';
    }
}
