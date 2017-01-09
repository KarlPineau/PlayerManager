<?php

namespace DnDRules\WeaponBundle\Form;

use PM\HomeBundle\Form\CriticalType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeaponEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',           'text',     array(  'required' => true))
            ->add('description',    'textarea', array(  'required' => false))
            ->add('weaponCategory', 'choice',   array(  'choices'  => array(
                1 => 'Corps à corps',
                2 => 'Tir',
            ),'required' => true))
            ->add('handsNumber',    'choice',   array(  'choices'  => array(
                1 => 'Une main',
                2 => 'Deux mains',
            ),'required' => true))
            ->add('price',          'text',     array(  'required' => true))
            ->add('scope',          'text',     array(  'required' => false))
            ->add('weight',         'text',     array(  'required' => false))
            ->add('damages',        'collection',array( 'type' => new WeaponDamageType(),
                'allow_add'    => true,
                'allow_delete' => true))
            ->add('criticals',      'collection',array( 'type' => new CriticalType(),
                'allow_add'    => true,
                'allow_delete' => true))
            ->add('weaponType',     'entity',   array(  'class' => 'DnDRulesWeaponBundle:WeaponType',
                'property' => 'name',
                'required' => true,
                'empty_value' => 'Type d\'Arme',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\WeaponBundle\Entity\Weapon'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_weapon_weapon_edit';
    }
}
