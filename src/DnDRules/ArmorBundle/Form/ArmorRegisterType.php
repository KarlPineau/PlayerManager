<?php

namespace DnDRules\ArmorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArmorRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',           'text',     array('required' => true))
            ->add('price',          'text',     array('required' => false))
            ->add('type',           'entity',   array(  'class' => 'DnDRulesArmorBundle:ArmorType',
                                                        'property' => 'name',
                                                        'required' => true,
                                                        'empty_value' => 'Type',
                                                        'empty_data'  => null))
            ->add('bonus',          'integer',  array('required' => false))
            ->add('dexterityBonus', 'integer',  array('required' => false))
            ->add('testMalus',      'integer',  array('required' => false))
            ->add('failRisks',      'integer',  array('required' => false))
            ->add('speedM',         'text',     array('required' => false))
            ->add('speedP',         'text',     array('required' => false))
            ->add('weight',         'text',     array('required' => false))
            ->add('description',    'textarea', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\ArmorBundle\Entity\Armor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_armorbundle_armor_register';
    }
}
