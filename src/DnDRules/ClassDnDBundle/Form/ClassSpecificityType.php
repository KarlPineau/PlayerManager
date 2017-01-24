<?php

namespace DnDRules\ClassDnDBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassSpecificityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',          'text',     array(  'required' => true,
                                                        'label' => 'Titre'))
            ->add('description',    'textarea', array(  'required' => false,
                                                        'label' => 'Description'))
            ->add('levelMin',       'entity',   array(  'class' => 'DnDRulesLevelBundle:Level',
                                                        'property'    => 'level',
                                                        'expanded' => false,
                                                        'multiple' => false,
                                                        'required' => false,
                                                        'empty_value' => 'Niveau',
                                                        'empty_data'  => null,
                                                        'label' => 'Niveau minimum'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\ClassDnDBundle\Entity\ClassSpecificity'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_classdndbundle_classspecificity';
    }
}
