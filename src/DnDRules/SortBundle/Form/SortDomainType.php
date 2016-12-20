<?php

namespace DnDRules\SortBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SortDomainType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minimumLevel',   'entity',  array(  'class' => 'DnDRulesLevelBundle:Level',
                                                        'property' => 'level',
                                                        'required' => true,
                                                        'empty_value' => 'Niveau',
                                                        'empty_data'  => null,
                                                        'label' => 'Niveau min. :'))
            ->add('domain',         'entity',   array(  'class' => 'DnDRulesSortBundle:Domain',
                                                        'property' => 'name',
                                                        'required' => true,
                                                        'empty_value' => 'Choisissez un domain',
                                                        'empty_data'  => null,
                                                        'label' => 'Domaine'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\SortBundle\Entity\SortDomain'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_sortbundle_sortdomain';
    }
}
