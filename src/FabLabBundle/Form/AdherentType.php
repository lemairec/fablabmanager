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
            ->add('name')
            ->add('surname')
            ->add('city')
            ->add('type',       ChoiceType::class, array(
                'choices'  => array(
                    'particulier' =>'particulier',
                    'professionnel' => 'professionnel',
                ),
            ))
            ->add('price_categorie', TextType::class, array('disabled' => true))
            ->add('actif')
            ->add('end_adhesion', DateType::class, array('disabled' => true))
            ->add('cf', NumberType::class, array('disabled' => true));
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
