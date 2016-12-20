<?php

namespace DnDRules\ClassDnDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassDnDLevelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level',              'entity',   array('class' => 'DnDRulesLevelBundle:Level',
                                                          'property'    => 'level',
                                                          'expanded' => false,
                                                          'multiple' => false,
                                                          'required' => true,
                                                          'empty_value' => 'Niveau',
                                                          'empty_data'  => null))
            ->add('classST',            'collection',array('type' => new ClassSTType(),
                                                          'allow_add'    => true,
                                                          'allow_delete' => true))
            ->add('classBABs',          'collection',array('type' => new ClassBABType(),
                                                          'allow_add'    => true,
                                                          'allow_delete' => true))
            ->add('classSorts',   'collection',array('type' => new ClassDnDSortType(),
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
            'data_class' => 'DnDRules\ClassDnDBundle\Entity\ClassDnDLevel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_classdndbundle_classdndlevel';
    }
}
