<?php

namespace DnDInstance\SortBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SortInstanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sort',   EntityType::class,  array( 'class' => 'DnDRulesSortBundle:Sort',
                                                       'choices' => $options['attr']['sorts'],
                                                       'property' => 'name',
                                                       'required' => true,
                                                       'empty_value' => 'Sélectionnez ...',
                                                       'empty_data'  => null))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDInstance\SortBundle\Entity\SortInstance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndinstance_sort_sort';
    }
}
