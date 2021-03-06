<?php

namespace DnDInstance\CharacterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CharacterSkillType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('skill',          'entity',   array(  'class' => 'DnDRulesSkillBundle:Skill',
                                                        'property' => 'name',
                                                        'required' => true,
                                                        'empty_value' => 'Compétences',
                                                        'empty_data'  => null,
                                                        'label' => 'Compétence :'))
            ->add('ranks',          'integer',  array(  'required' => true,
                                                        'label' => 'Niveau :'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDInstance\CharacterBundle\Entity\CharacterSkill'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndinstance_characterbundle_characterskill';
    }
}
