<?php

namespace App\Form;

use App\Entity\Pokemon;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'Donner des rôles',
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Utilisateur' =>  'ROLE_USER',
                ]
            ])
            ->add('pokemon', EntityType::class, [
                'class' => Pokemon::class,
                'choice_label' => 'nom',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
