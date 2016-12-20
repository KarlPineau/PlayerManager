<?php

namespace PM\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CriticalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rangeCriticalBegin',        'integer',  array(   'required' => true,
                                                                    'label' => 'Plage :',
                                                                    'attr' => array(
                                                                        'class' => 'form-control'
                                                                    )))
            ->add('rangeCriticalEnd',          'integer',  array(   'required' => true,
                                                                    'label' => '-',
                                                                    'attr' => array(
                                                                        'class' => 'form-control'
                                                                    )))
            ->add('multiplier',                'integer',  array(   'required' => true,
                                                                    'label' => 'Multiplicateur :',
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
            'data_class' => 'PM\HomeBundle\Entity\Critical'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pm_homebundle_critical';
    }
}
