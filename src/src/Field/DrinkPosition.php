<?php

namespace App\Field;

use App\Config\LengthConfig;
use App\Entity\Ingredient;
use App\Model\DrinkPosition as Model;
use App\Repository\IngredientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class DrinkPosition extends AbstractType
{
    private array $ingredients;

    public function __construct(IngredientRepository $ingredientRepository, TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();
        $this->ingredients = $ingredientRepository->findForUser($user);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('amount', null, [
            'constraints' => [
                new Length([
                    'max' => LengthConfig::AMOUNT
                ])
            ]
        ])
            ->add('ingredient', EntityType::class, [
                'choices' => $this->ingredients,
                'class' => Ingredient::class,
                'constraints' => [
                    new NotNull()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Model::class
        ]);
    }
}
