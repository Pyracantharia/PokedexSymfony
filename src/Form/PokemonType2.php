<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class PokemonType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Length([
                        'max' => 30 
                    ])
                ]
            ])
            ->add('numero', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range([
                        'min' => 1,
                        'max' => 150,
                        'minMessage' => 'La valeur doit être supérieur à  {{ min }}',
                        'maxMessage' => 'La valeur doit être inférieur à {{ max }}'
                    ])
                ],
                'label' => 'Numéro',
                'invalid_message' => 'Le champ doit être un nombre'
            ])
            ->add('type', ChoiceType::class, [
                'constraints' => [
                    new NotBlank(
                        ['message' => 'Veuillez choisir un type']
                    )
                ],
                'choices' => [
                    'Choisissez un type' => null,
                    'Feu' => 'feu',
                    'Eau' =>  'eau',
                    'Fee' => 'fee',
                    'Psy' => 'psy',
                    'Electrique' => 'electrique'
                ]
            ])
            ->add('level', TextType::class, [
                'label' => $options['label'],
                'required' => $options['required']
            ])
            ->add('anniversaire', DateTimeType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'label' => 'Un champs',
           'required' => true
        ]);
    }
}
