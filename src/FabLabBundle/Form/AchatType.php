<?php

namespace FabLabBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityRepository;

class AchatType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categorie = $options['categorie'];
        $builder
            ->add('date')
            ;
        if($categorie == 'A'){
            $builder->add('produit', EntityType::class, array(
                'class' => 'FabLabBundle:Produit',
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('p')->where("p.categorie = 'A'"); },
                'choice_label' => 'label',
            )) ;
        } else {
            $builder->add('produit', EntityType::class, array(
                'class' => 'FabLabBundle:Produit',
                'query_builder' => function (EntityRepository $er) { return $er->createQueryBuilder('p')->where("p.categorie = 'B'"); },
                'choice_label' => 'label',
            )) ;

        }
        $builder->add('qty');
        $builder->add('descriptif');
        $builder->add('save',      SubmitType::class, array('label' => 'Save'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FabLabBundle\Entity\Achat'
        ));
        $resolver->setRequired('categorie');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fablabbundle_achat';
    }


}
