<?php

namespace DnDRules\WeaponBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PM\HomeBundle\Form\DiceFormType;

class WeaponDamageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('size',      'entity',        array(  'class' => 'DnDRulesSizeBundle:Size',
                                                        'property' => 'name',
                                                        'required' => true,
                                                        'empty_value' => 'Type',
                                                        'attr' => array(
                                                            'class' => 'form-control'
                                                        )))
            ->add('damage',     'collection',   array(  'type' => new DiceFormType(),
                                                        'allow_add'    => true,
                                                        'allow_delete' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\WeaponBundle\Entity\WeaponDamage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_weaponbundle_weapondamage';
    }
}
