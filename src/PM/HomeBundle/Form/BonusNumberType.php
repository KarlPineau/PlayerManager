<?php

namespace PM\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BonusNumberType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value',      'integer',      array(  'required' => true,
                                                        'label' => 'Bonus : ',
                                                        'attr' => array(
                                                            'class' => 'form-control'
                                                        )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PM\HomeBundle\Entity\BonusNumber'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pm_homebundle_bonusnumber';
    }
}
