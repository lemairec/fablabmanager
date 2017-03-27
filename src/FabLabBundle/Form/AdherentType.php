<?php

namespace FabLabBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AdherentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('no')
            ->add('type',       ChoiceType::class, array(
                'choices'  => array(
                    'particulier' =>'particulier',
                    'professionnel' => 'professionnel',
                ),
            ))
            ->add('name')
            ->add('surname')
            ->add('adresse')
            ->add('code_postal')
            ->add('city')
            ->add('birthday', DateType::class)
            ->add('sexe',       ChoiceType::class, array(
                'choices'  => array(
                    'M'=>'M','F'=>'F','N'=>'N'
                ),
            ))
            ->add('activite')
            ->add('mail')
            ->add('fondateur')
            ->add('actif')
            ->add('bureau')
            ->add('ca')
            ->add('lettre_info')
            ->add('remarque')
        ;
        $builder->add('save',      SubmitType::class, array('label' => 'Save'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FabLabBundle\Entity\Adherent'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fablabbundle_adherent';
    }


}
