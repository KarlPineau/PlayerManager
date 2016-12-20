<?php

namespace DnDRules\AbilityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AbilityRegisterType extends AbstractType
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
            ->add('type',           'integer',      array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\AbilityBundle\Entity\Ability'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_abilitybundle_ability_register';
    }
}
