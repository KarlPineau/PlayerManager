<?php

namespace DnDRules\ArmorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArmorTypeRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',           'text',         array('required' => true))
            ->add('description',    'textarea',     array('required' => false))
            ->add('type',           'text',         array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\ArmorBundle\Entity\ArmorType'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_armorbundle_armortype_register';
    }
}
