<?php

namespace DnDInstance\WeaponBundle\Form;

use DnDRules\WeaponBundle\Form\WeaponDamageType;
use PM\HomeBundle\Form\CriticalType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeaponInstanceEditType extends AbstractType
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
            ->add('priceValue',     'text',     array(  'required' => false))
            ->add('scope',          'text',     array(  'required' => false))
            ->add('weight',         'text',     array(  'required' => false))
            ->add('damages',        'collection',array( 'type' => new WeaponDamageType(),
                                                        'allow_add'    => true,
                                                        'allow_delete' => true))
            ->add('criticals',      'collection',array( 'type' => new CriticalType(),
                                                        'allow_add'    => true,
                                                        'allow_delete' => true))
            ->add('handsNumber',    'choice',   array(  'choices'  => array(
                                                            1 => 'Une main',
                                                            2 => 'Deux mains'),
                                                        'required' => true))
            ->add('weaponCategory', 'choice',   array(  'choices'  => array(
                                                            1 => 'Corps à corps',
                                                            2 => 'Tir',
                                                        ),'required' => true))
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
            'data_class' => 'DnDInstance\WeaponBundle\Entity\WeaponInstance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndinstance_weapon_weapon_edit';
    }
}
