<?php

namespace DnDRules\MonsterBundle\Form;

use PM\HomeBundle\Form\DiceFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonsterAttacksExtremeShortType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attackExtremeDescription',  'textarea',  array(  'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\MonsterBundle\Entity\Monster'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_monsterbundle_monster_edit';
    }
}
