<?php

namespace DnDInstance\CharacterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use DnDInstance\ClassDnDBundle\Form\ClassDnDInstanceType;
use Doctrine\ORM\EntityRepository;

class CharacterUsedRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',               'entity',   array(  'class' => 'CASUserBundle:User',
                                                            'property' => 'username',
                                                            'query_builder' => function (EntityRepository $er) use($options) {
                                                                if($options['attr']['role'] == 'admin') {
                                                                    return $er->createQueryBuilder('u');
                                                                } elseif($options['attr']['role'] == 'public') {
                                                                    return $er->createQueryBuilder('u')
                                                                        ->where('u.id = :id')
                                                                        ->setParameters(array('id' => $options['attr']['user_id']));
                                                                }
                                                            },
                                                            'required' => true,
                                                            'empty_value' => 'Choisissez un propriétaire',))
            ->add('game',               'entity',   array(  'class' => 'GameGameBundle:Game',
                                                            'query_builder' => function (EntityRepository $er) use($options) {
                                                                return $er->createQueryBuilder('g')
                                                                          ->where('g.active = 1');
                                                            },
                                                            'property' => 'name',
                                                            'required' => true,
                                                            'empty_value' => 'Choisissez une Partie',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDInstance\CharacterBundle\Entity\CharacterUsed'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndinstance_characterbundle_characterused_register';
    }
}
