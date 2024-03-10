<?php

namespace App\Form;

use App\Config\LengthConfig;
use App\Entity\Drink;
use App\Entity\Ingredient;
use App\Entity\Tag;
use App\Field\DrinkPosition;
use App\Model\DrinksCard;
use App\Repository\DrinkRepository;
use App\Repository\IngredientRepository;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class DrinksCardForm extends UserForm
{
    private array $tags;
    private array $ingredients;
    private array $drinks;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        IngredientRepository $ingredientRepository,
        TagRepository $tagRepository,
        DrinkRepository $drinkRepository
    )
    {
        parent::__construct($tokenStorage);
        $this->tags = $tagRepository->findForUser($this->user);
        $this->ingredients = $ingredientRepository->findForUser($this->user);
        $this->drinks = $drinkRepository->findForUser($this->user);
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'name',
            null,
            [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => LengthConfig::DRINKS_CARD
                    ])
                ]
            ]
        )
            ->add('active', ChoiceType::class, [
                'choices' => [
                    'yes' => '1',
                    'no' => '0'
                ]
            ])
            ->add('availableTags', EntityType::class, [
                'multiple' => true,
                'choices' => $this->tags,
                'class' => Tag::class
            ])
            ->add('excludedTags', EntityType::class, [
                'multiple' => true,
                'choices' => $this->tags,
                'class' => Tag::class
            ])
            ->add('availableIngredients', EntityType::class, [
                'multiple' => true,
                'choices' => $this->ingredients,
                'class' => Ingredient::class
            ])
            ->add('excludedIngredients', EntityType::class, [
                'multiple' => true,
                'choices' => $this->ingredients,
                'class' => Ingredient::class
            ])
            ->add('availableDrinks', EntityType::class, [
                'multiple' => true,
                'choices' => $this->drinks,
                'class' => Drink::class
            ])
            ->add('excludedDrinks', EntityType::class, [
                'multiple' => true,
                'choices' => $this->drinks,
                'class' => Drink::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => DrinksCard::class,
                'csrf_protection' => false
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
