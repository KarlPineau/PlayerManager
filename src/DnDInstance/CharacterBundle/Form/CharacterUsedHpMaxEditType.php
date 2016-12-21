<?php

namespace DnDInstance\CharacterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CharacterUsedHpMaxEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hpMaxAdd',          'integer',  array('required' => true, 'mapped' => false))
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
        return 'dndinstance_characterbundle_characterused_edit_hp_max';
    }
}
