<?php

namespace PM\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DiceFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('diceEntities',       'collection',   array(  'type' => new DiceEntityType(),
                                                                'allow_add'    => true,
                                                                'allow_delete' => true))
            ->add('bonusNumbers',       'collection',   array(  'type' => new BonusNumberType(),
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
            'data_class' => 'PM\HomeBundle\Entity\DiceForm'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pm_homebundle_diceform';
    }
}
