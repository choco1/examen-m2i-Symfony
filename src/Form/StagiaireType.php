<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'attr' => [
                    'placeholder' => "Nom du stagiaire"
                ]
            ])
            ->add('phone',NumberType::class, [
                'attr' => [
                    'placeholder' => "Numéro de telephone"
                ]
            ])
            ->add('created_at', DateType::class, [
                'widget' => 'choice',
                'attr' => [
                    'placeholder' => "Date de création du stagiaire"
                ]
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'choice',
                'attr' => [
                    'placeholder' => "Date de l'anniversaire"
                ]
            ])
            ->add('competence', null, [
                'choice_label' => 'name',
                'expanded' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
