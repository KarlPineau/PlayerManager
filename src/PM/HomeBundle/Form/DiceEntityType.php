<?php

namespace PM\HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DiceEntityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('diceNumber',     'integer',      array(  'required' => true,
                                                            'label' => 'Nb : ',
                                                            'attr' => array(
                                                                'class' => 'form-control'
                                                            )))
            ->add('diceType',       'entity',       array(  'class' => 'PMHomeBundle:DiceType',
                                                            'property'    => 'dice',
                                                            'required' => true,
                                                            'empty_value' => 'Dé de ...',
                                                            'query_builder' => function(\PM\HomeBundle\Entity\DiceTypeRepository $er) {
                                                                return $er->createQueryBuilder('u')
                                                                    ->orderBy('u.dice', 'ASC');
                                                            },
                                                            'label' => 'dé :',
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
            'data_class' => 'PM\HomeBundle\Entity\DiceEntity'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pm_homebundle_diceentity';
    }
}
