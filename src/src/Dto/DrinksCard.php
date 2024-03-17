<?php

namespace App\Dto;

use App\Entity\Drink;
use App\Entity\DrinksCard as Entity;
use App\Entity\Ingredient;
use App\Entity\Tag;
use InvalidArgumentException;

class DrinksCard implements DtoInterface
{
    private int $id;
    private string $name;
    private bool $active;
    private string $publicId;
    private array $availableTags;
    private array $excludedTags;
    private array $availableIngredients;
    private array $excludedIngredients;
    private array $availableDrinks;
    private array $excludedDrinks;

    public function __construct(
        int $id,
        string $name,
        bool $active,
        string $publicId,
        array $availableTags,
        array $excludedTags,
        array $availableIngredients,
        array $excludedIngredients,
        array $availableDrinks,
        array $excludedDrinks
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->active = $active;
        $this->publicId = $publicId;
        $this->availableTags = array_map(
            static fn(Tag $tag): int => $tag->getId(),
            $availableTags
        );
        $this->excludedTags = array_map(
            static fn(Tag $tag): int => $tag->getId(),
            $excludedTags
        );
        $this->availableIngredients = array_map(
            static fn(Ingredient $ingredient): int => $ingredient->getId(),
            $availableIngredients
        );
        $this->excludedIngredients = array_map(
            static fn(Ingredient $ingredient): int => $ingredient->getId(),
            $excludedIngredients
        );
        $this->availableDrinks = array_map(
            static fn(Drink $drink): int => $drink->getId(),
            $availableDrinks
        );
        $this->excludedDrinks = array_map(
            static fn(Drink $drink): int => $drink->getId(),
            $excludedDrinks
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public static function createFromEntity(mixed $entity): DtoInterface
    {
        if (!($entity instanceof Entity)) {
            throw new InvalidArgumentException(
                sprintf('Parameter "entity" isn\'t an instance of "%s" class', Entity::class)
            );
        }

        return new self(
            $entity->getId(),
            $entity->getName(),
            $entity->isActive(),
            $entity->getPublicId(),
            array_values($entity->getAvailableTags()->toArray()),
            array_values($entity->getExcludedTags()->toArray()),
            array_values($entity->getAvailableIngredients()->toArray()),
            array_values($entity->getExcludedIngredients()->toArray()),
            array_values($entity->getAvailableDrinks()->toArray()),
            array_values($entity->getExcludedDrinks()->toArray())
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getPublicId(): string
    {
        return $this->publicId;
    }

    public function getAvailableTags(): array
    {
        return $this->availableTags;
    }

    public function getExcludedTags(): array
    {
        return $this->excludedTags;
    }

    public function getAvailableIngredients(): array
    {
        return $this->availableIngredients;
    }

    public function getExcludedIngredients(): array
    {
        return $this->excludedIngredients;
    }

    public function getAvailableDrinks(): array
    {
        return $this->availableDrinks;
    }

    public function getExcludedDrinks(): array
    {
        return $this->excludedDrinks;
    }
}
