<?php

namespace DnDInstance\CharacterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CharacterWealthType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('poAdd', 'integer', array('required' => true, 'mapped' => false))
            ->add('paAdd', 'integer', array('required' => true, 'mapped' => false))
            ->add('pcAdd', 'integer', array('required' => true, 'mapped' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DnDInstance\CharacterBundle\Entity\CharacterWealth'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dndinstance_characterbundle_characterwealth';
    }
}
