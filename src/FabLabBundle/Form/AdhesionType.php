<?php

namespace FabLabBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdhesionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date')
            ->add('type')
        ;
        $categorie = $options['categorie'];
        if($categorie == 'A'){
            $builder->add('type',       ChoiceType::class, array(
                'choices'  => array(
                    'particulier' =>'particulier',
                    'etudiant' => 'etudiant',
                ),
            ));
        } else {
             $builder->add('type',       ChoiceType::class, array(
                'choices'  => array(
                    'professionnel' =>'professionnel',
                ),
            ));

        }
        $builder->add('save',      SubmitType::class, array('label' => 'Save'));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FabLabBundle\Entity\Adhesion'
        ));
        $resolver->setRequired('categorie');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fablabbundle_adhesion';
    }


}
