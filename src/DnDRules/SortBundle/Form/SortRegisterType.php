<?php

namespace DnDRules\SortBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SortRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',           'text',     array('required' => true))
            ->add('description',    'textarea', array('required' => false))
            ->add('composantes',    'entity',   array(  'class' => 'DnDRulesSortBundle:Composante',
                                                        'property' => 'name',
                                                        'required' => false,
                                                        'empty_data'  => null,
                                                        'expanded' => false,
                                                        'multiple' => true))
            ->add('sortSchool',     'entity',   array(  'class' => 'DnDRulesSortBundle:SortSchool',
                                                        'property' => 'name',
                                                        'required' => false,
                                                        'empty_value' => 'Choisissez une Ecole',
                                                        'empty_data'  => null))
            ->add('sortSchoolPlugged','text',     array('required' => false))
            ->add('sortSchoolRegistre','text',     array('required' => false))
            ->add('castTime',       'text',     array('required' => false))
            ->add('scope',          'text',     array('required' => false))
            ->add('effect',         'textarea', array('required' => false))
            ->add('effectzone',     'text',     array('required' => false))
            ->add('period',         'text',     array('required' => false))
            ->add('jds',            'text',     array('required' => false))
            ->add('magicResistance','text',     array('required' => false))
            ->add('target',         'text',     array('required' => false))
            ->add('classes',        'collection',array('type' => new SortClassDnDType(),
                                                      'allow_add'    => true,
                                                      'allow_delete' => true))
            ->add('domains',        'collection',array('type' => new SortDomainType(),
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
            'data_class' => 'DnDRules\SortBundle\Entity\Sort'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_sortbundle_sort_register';
    }
}
