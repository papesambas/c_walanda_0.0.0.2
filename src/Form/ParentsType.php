<?php

namespace App\Form;

use App\Entity\Parents;
use App\Form\MeresType;
use App\Form\PeresType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pere', PeresType::class, [
            'label' => false,
            'required' => false
        ])
        ->add('mere', MeresType::class, [
            'label' => false,
            'required' => false
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parents::class,
        ]);
    }
}
