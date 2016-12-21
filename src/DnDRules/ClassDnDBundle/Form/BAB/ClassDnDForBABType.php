<?php

namespace DnDRules\ClassDnDBundle\Form\BAB;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassDnDForBABType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('levels',          'collection',array('type' => new ClassDnDLevelForBABType(),
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
            'data_class' => 'DnDRules\ClassDnDBundle\Entity\ClassDnD'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_classdndbundle_classDnD_register';
    }
}
