<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir un prénom']),
                    new Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Votre prénom doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre prénom ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('last_name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir un nom']),
                    new Length([
                        'min' => 3,
                        'max' => 20,
                        'minMessage' => 'Votre nom doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre nom ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir un e-mail']),
                    new Email(['message' => 'Veuillez saisir un e-mail valide']),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe', // Label personnalisé
                    
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe', // Label personnalisé
                    
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir un mot de passe']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères.',
                    ]),
                ],
            ])
            
            ->add('conditions', CheckboxType::class, [
                'label' => "Veuillez accepter les conditions d'utilisations.",
                'mapped' => false,
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter les conditions d’utilisation.']),
                ],
                'attr' => ['class' => 'ip-champ-checkbox']  // Ajout d'une classe pour cibler cet élément
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
