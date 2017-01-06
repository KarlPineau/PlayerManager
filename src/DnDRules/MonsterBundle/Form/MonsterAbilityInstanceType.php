<?php

namespace DnDRules\MonsterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonsterAbilityInstanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value',          'integer',      array('required' => true,
                                                          'scale' => 2,
                                                          'label' => 'Valeur',
                                                          'attr' => array('class' => 'form-control')))
            ->add('ability',        'entity',       array('class' => 'DnDRulesAbilityBundle:Ability',
                                                          'property'    => 'name',
                                                          'expanded' => false,
                                                          'multiple' => false,
                                                          'required' => true,
                                                          'empty_value' => 'Caractérisique',
                                                          'empty_data'  => null,
                                                          'label' => 'Caractéristique',
                                                          'attr' => array('class' => 'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\MonsterBundle\Entity\MonsterAbilityInstance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_monsterbundle_monsterabilityinstance';
    }
}
