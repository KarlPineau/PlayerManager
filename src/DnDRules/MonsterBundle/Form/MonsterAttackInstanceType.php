<?php

namespace DnDRules\MonsterBundle\Form;

use PM\HomeBundle\Form\CriticalType;
use PM\HomeBundle\Form\DiceFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MonsterAttackInstanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',               'text',     array('required' => true,
                                                          'label' => 'Nom de l\'attaque'))
            ->add('weapon',             'entity',   array('class' => 'DnDRulesWeaponBundle:Weapon',
                                                          'property' => 'name',
                                                          'group_by' => function($val, $key, $index) {
                                                                return $val->getWeaponType()->getName();
                                                          },
                                                          'required' => false,
                                                          'empty_value' => 'Sélectionnez ...',
                                                          'attr' => array(
                                                              'class' => 'form-control'
                                                          ),
                                                          'label' => 'Arme'))
            ->add('bab',                'integer',  array('required' => true,
                                                          'label' => 'Bonus de Base à l\'Attaque'))
            ->add('damageSideEffect',   'text',     array('required' => false,
                                                          'label' => 'Effets secondaires'))
            ->add('onlyExtreme',          'choice',  array('required' => true,
                                                           'choices'  => array(true => 'Oui', false => 'Non'),
                                                           'data' => false,
                                                           'multiple' => false,
                                                           'expanded' => false,
                                                           'label' => 'Utilisable uniquement en attaque à outrance ?'))
            ->add('damageForms',         'collection',array('type' => new DiceFormType(),
                                                           'allow_add'    => true,
                                                           'allow_delete' => true,
                                                           'required' => false,
                                                           'label' => 'Dés de dégat'))
            ->add('damageCriticForms',   'collection',array('type' => new CriticalType(),
                                                           'allow_add'    => true,
                                                           'allow_delete' => true,
                                                           'required' => false,
                                                           'label' => 'Formule du critique'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDRules\MonsterBundle\Entity\MonsterAttackInstance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndrules_monsterbundle_monsterattackinstance';
    }
}
