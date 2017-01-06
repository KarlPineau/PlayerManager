<?php

namespace DnDRules\MonsterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonsterAttacksExtremeInstanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number',                         'integer',      array('required' => true))
            ->add('monsterAttackExtremeInstances',  'entity',       array('class' => 'DnDRulesWeaponBundle:Weapon',
                                                                        'property' => 'name',
                                                                        'group_by' => function($val, $key, $index) {
                                                                            return $val->getWeaponType()->getName();
                                                                        },
                                                                        'required' => false,
                                                                        'empty_value' => 'Sélectionnez ...',
                                                                        'attr' => array(
                                                                            'class' => 'form-control'
                                                                        )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\MonsterBundle\Entity\MonsterAttacksExtremeInstance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_monsterbundle_monsterattacksextremeinstance';
    }
}
