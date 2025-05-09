<?php

namespace App\Form;

use App\Entity\Noms;
use App\Entity\Meres;
use App\Entity\Ninas;
use App\Entity\Users;
use App\Entity\Prenoms;
use App\Entity\Professions;
use App\Entity\Telephones1;
use App\Entity\Telephones2;
use App\Repository\NomsRepository;
use App\Repository\NinasRepository;
use App\Repository\PrenomsRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\ProfessionsRepository;
use App\Repository\Telephones1Repository;
use App\Repository\Telephones2Repository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use App\Form\DataTransformer\EmailNormalizerTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class MeresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', EntityType::class, [
            'class' => Noms::class,
            'choice_label' => 'designation',
            'label' => 'Choisissez un nom',
            'placeholder' => 'Sélectionnez...',
            'query_builder' => function (NomsRepository $er) {
                return $er->createQueryBuilder('n')
                    ->orderBy('n.designation', 'ASC');
            },
            'attr' => [
                'class' => 'select2 select-nom' // Si utilisation de Select2
            ],
            'required' => true,
        ])
            ->add('prenom', EntityType::class, [
                'class' => Prenoms::class,
                'choice_label' => 'designation',
                'label' => 'Choisissez un prénom',
                'placeholder' => 'Sélectionnez...',
                'query_builder' => function (PrenomsRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select2 select-prenom' // Si utilisation de Select2
                ],
                'required' => true,
            ])
            ->add('profession', EntityType::class, [
                'class' => Professions::class,
                'choice_label' => 'designation',
                'label' => 'Choisissez une profession',
                'placeholder' => 'Sélectionnez...',
                'query_builder' => function (ProfessionsRepository $er) {
                    return $er->createQueryBuilder('pr')
                        ->orderBy('pr.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select2 select-profession' // Si utilisation de Select2
                ],
                'required' => true,
            ])
            ->add('nina', EntityType::class, [
                'class' => Ninas::class,
                'choice_label' => 'numero',
                'label' => 'Numéro NINA',
                'placeholder' => 'Sélectionnez un numéro...',
                'query_builder' => function (NinasRepository $er) {
                    return $er->createQueryBuilder('n')
                        //->where('n.actif = true') // Filtre optionnel
                        ->orderBy('n.numero', 'ASC');
                },
                'attr' => [
                    'class' => 'select2 select-nina',
                    'data-max-length' => 15
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => "/^[A-Za-z0-9]{13} [A-Za-z]$/",
                        'message' => "Format attendu : 13 caractères alphanumériques + espace + 1 lettre (ex: AB123456789012 C)"
                    ])
                ]
            ])
            ->add('telephone1', EntityType::class, [
                'class' => Telephones1::class,
                'choice_label' => 'numero',
                'label' => 'Téléphone 1',
                'placeholder' => 'Sélectionnez un numéro...',
                'query_builder' => function (Telephones1Repository $er) {
                    return $er->createQueryBuilder('t1')
                        ->orderBy('t1.numero', 'ASC');
                },
                'attr' => [
                    'class' => 'select2 select-telephone1' // Si utilisation de Select2
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => "/^(?:(?:\+|00)223|0)[1-9]([\s.-]*\d{2}){4}$/",
                        'message' => "Format invalide. Ex: 88585858, 23 45 67 89, +233 23 45 67 89"
                    ])
                ]
            ])
            ->add('telephone2', EntityType::class, [
                'class' => Telephones2::class,
                'choice_label' => 'numero',
                'label' => 'Téléphone 2',
                'placeholder' => 'Sélectionnez un numéro...',
                'query_builder' => function (Telephones2Repository $er) {
                    return $er->createQueryBuilder('t2')
                        ->orderBy('t2.numero', 'ASC');
                },
                'attr' => [
                    'class' => 'select2 select-telephone2' // Si utilisation de Select2
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => "/^(?:(?:\+|00)223|0)[1-9]([\s.-]*\d{2}){4}$/",
                        'message' => "Format invalide. Ex: 88585858, 23 45 67 89, +233 23 45 67 89"
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => [
                    'placeholder' => 'exemple@domaine.com',
                    'maxlength' => 180,
                    'class' => 'form-control-email',
                    'autocomplete' => 'email'
                ],
                'required' => true,
                'constraints' => [
                    new Assert\Email([
                        'message' => 'Veuillez saisir une adresse email valide.',
                        'mode' => Assert\Email::VALIDATION_MODE_STRICT
                    ]),
                    new Assert\Length([
                        'max' => 180,
                        'maxMessage' => 'L\'email ne peut excéder {{ limit }} caractères.'
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                        'allowNull' => true
                    ])
                ],
                'help' => 'Format attendu : utilisateur@domaine.com',
                'empty_data' => null
            ])
            ->add('adresse',TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse complète',
                    'maxlength' => 255,
                    'class' => 'form-control-adresse'
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'L\'adresse ne peut excéder {{ limit }} caractères.'
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                        'allowNull' => true
                    ])
                ],
            ])
            ->addModelTransformer(new EmailNormalizerTransformer())
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meres::class,
        ]);
    }
}
