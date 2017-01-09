<?php

namespace DnDRules\RaceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaceSTType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fortitude',  'integer',  array('required' => false, 'empty_data' => 0))
            ->add('reflex',     'integer',  array('required' => false, 'empty_data' => 0))
            ->add('will',       'integer',  array('required' => false, 'empty_data' => 0))
            ->add('specificity',        'textarea', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\RaceBundle\Entity\RaceST'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_racebundle_racest';
    }
}
