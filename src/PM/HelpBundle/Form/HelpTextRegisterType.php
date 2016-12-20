<?php

namespace PM\HelpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HelpTextRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',      'text',         array('required' => true))
            ->add('text',       'textarea',     array('required' => true))
            ->add('entity',     'text',         array('required' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PM\HelpBundle\Entity\HelpText'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pm_helpbundle_helptext_register';
    }
}
