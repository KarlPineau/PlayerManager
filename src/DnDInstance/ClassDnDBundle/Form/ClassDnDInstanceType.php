<?php

namespace DnDInstance\ClassDnDBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassDnDInstanceType extends AbstractType
{
    private $levelMin;
    private $levelMax;
    private $openClasses;

    public function __construct($levelMin, $levelMax, $openClasses)
    {
        $this->levelMin = $levelMin;
        $this->levelMax = $levelMax;
        $this->openClasses = $openClasses;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $levelMin = $this->levelMin;
        $levelMax = $this->levelMax;
        $openClasses = $this->openClasses;

        $builder
            ->add('classDnD',   'entity',   array(  'class' => 'DnDRulesClassDnDBundle:ClassDnD',
                                                    'choices' => $openClasses,
                                                    'property' => 'name',
                                                    'required' => true,
                                                    'label' => 'Classe',
                                                    'empty_value' => 'Choisissez une classe',))
            ->add('level',      'entity',   array(  'class' => 'DnDRulesLevelBundle:Level',
                                                    'query_builder' => function (EntityRepository $er) use($options, $levelMin, $levelMax) {
                                                        return $er->createQueryBuilder('l')
                                                                    ->where('l.level >= :levelMin')
                                                                    ->andWhere('l.level <= :levelMax')
                                                                    ->setParameters(array('levelMin' => $levelMin, 'levelMax' => $levelMax));
                                                    },
                                                    'property' => 'level',
                                                    'required' => true,
                                                    'label' => 'Niveau',
                                                    'empty_value' => 'Niveau',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDInstance\ClassDnDBundle\Entity\ClassDnDInstance'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndinstance_classdnd_classdnd';
    }
}
