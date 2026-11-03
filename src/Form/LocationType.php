<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'attr' => [
                    'placeholder' => 'City',
        ],
        ])
            ->add('country', ChoiceType::class, [
               'choices' => [
                   'Poland' => 'PL',
                   'Germany' => 'GE',
                   'France' => 'FR',
                   'Italy' => 'IT',
                   'Spain' => 'ES',
                   'United States' => 'US',
                   'Australia' => 'AU',
               ],
            ])
            ->add('latitude', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Latitude',
                ],
            ])
            ->add('longitude', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Longitude',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
