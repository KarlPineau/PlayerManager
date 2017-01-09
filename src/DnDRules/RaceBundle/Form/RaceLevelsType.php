<?php

namespace DnDRules\RaceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaceLevelsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raceLevels',     'collection',   array(  'type' => new RaceLevelType(),
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
            'data_class' => 'DnDRules\RaceBundle\Entity\RaceLevels'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_race_race_levels';
    }
}
