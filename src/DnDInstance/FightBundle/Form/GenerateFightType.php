<?php

namespace DnDInstance\FightBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GenerateFightType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('monsterInstances',    'entity',   array(  'class' => 'DnDInstanceMonsterBundle:MonsterInstance',
                                                    'property'    => 'name',
                                                    'expanded' => false,
                                                    'multiple' => true,
                                                    'required' => false,
                                                    'empty_data'  => null,
                                                    'mapped' => false))
            ->add('characters',         'entity',   array(  'class' => 'DnDInstanceCharacterBundle:CharacterUsed',
                                                    'property'    => 'name',
                                                    'expanded' => false,
                                                    'multiple' => true,
                                                    'required' => false,
                                                    'empty_data'  => null,
                                                    'mapped' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndinstance_fightbundle_fight_generate';
    }
}
