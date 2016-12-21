<?php

namespace DnDRules\ClassDnDBundle\Form\ST;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassSTType extends AbstractType
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
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\ClassDnDBundle\Entity\ClassST'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_classdndbundle_classst';
    }
}
