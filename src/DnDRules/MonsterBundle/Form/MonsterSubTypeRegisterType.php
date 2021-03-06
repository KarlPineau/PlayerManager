<?php

namespace DnDRules\MonsterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonsterSubTypeRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',               'text',     array('required' => true))
            ->add('description',        'textarea', array('required' => false))
            ->add('monsterType',        'entity',   array(  'class' => 'DnDRulesMonsterBundle:MonsterType',
                                                            'property' => 'name',
                                                            'required' => true,
                                                            'empty_value' => 'Type de Monstre'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\MonsterBundle\Entity\MonsterSubType'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_monsterbundle_monstersubtype_register';
    }
}
