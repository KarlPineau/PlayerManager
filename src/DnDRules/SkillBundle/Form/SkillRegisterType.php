<?php

namespace DnDRules\SkillBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SkillRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',           'text',     array(  'required' => true))
            ->add('ability',        'entity',   array(  'class' => 'DnDRulesAbilityBundle:Ability',
                                                        'property'    => 'name',
                                                        'expanded' => false,
                                                        'multiple' => false,
                                                        'required' => false,
                                                        'empty_value' => 'Compétences de Classe',
                                                        'empty_data'  => null))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\SkillBundle\Entity\Skill'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'DnDRules_skillbundle_skill_register';
    }
}
