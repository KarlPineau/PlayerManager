<?php

namespace DnDInstance\WeaponBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeaponInstanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('weapon',     'entity',       array(  'class' => 'DnDRulesWeaponBundle:Weapon',
                                                        'property' => 'name',
                                                        'group_by' => function($val, $key, $index) {
                                                            return $val->getWeaponType()->getName();
                                                        },
                                                        'required' => true,
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
            'data_class' => 'DnDInstance\WeaponBundle\Entity\WeaponInstance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndinstance_weapon_weapon';
    }
}
