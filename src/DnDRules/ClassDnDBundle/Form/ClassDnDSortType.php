<?php

namespace DnDRules\ClassDnDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassDnDSortType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sortLevel',          'entity',   array('class' => 'DnDRulesLevelBundle:Level',
                                                          'property'    => 'level',
                                                          'expanded' => false,
                                                          'multiple' => false,
                                                          'required' => false,
                                                          'empty_value' => 'Niveau',
                                                          'empty_data'  => null))
            ->add('maximumUsedSorts',   'number',   array('required' => false))
            ->add('maximumKnownSorts',  'number',   array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\ClassDnDBundle\Entity\ClassDnDSort'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_classdndbundle_classdndsort';
    }
}
