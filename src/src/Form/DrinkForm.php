<?php

namespace App\Form;

use App\Config\LengthConfig;
use App\Field\DrinkPosition;
use App\Model\Drink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class DrinkForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', null, [
            'constraints' => [
                new NotBlank(),
                new Length([
                    'max' => LengthConfig::DRINK
                ])
            ],
            'trim' => true
        ])
            ->add('description', null, [
                'constraints' => [
                    new Type([
                        'type' => 'string'
                    ])
                ],
                'trim' => true
            ])
            ->add('favourite', CheckboxType::class)
            ->add('public', CheckboxType::class)
            ->add('tags', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'entry_options' => [
                    'constraints' => [
                        new NotBlank(),
                        new Length([
                            'max' => LengthConfig::TAG
                        ])
                    ]
                ]
            ])
            ->add('positions', CollectionType::class, [
                'entry_type' => DrinkPosition::class,
                'allow_add' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Drink::class,
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
