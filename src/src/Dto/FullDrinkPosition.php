<?php

namespace App\Dto;

use App\Entity\DrinkPosition as Entity;
use App\Entity\Ingredient;
use InvalidArgumentException;

class FullDrinkPosition implements DtoInterface
{
    private int $id;
    private string $amount;
    private string $ingredient;
    private string $ingredientDescription;

    public function __construct(int $id, string $amount, Ingredient $ingredient)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->ingredient = $ingredient->getName();
        $this->ingredientDescription = $ingredient->getDescription();
    }

    /**
     * @param  Entity  $entity
     *
     * @return self
     */
    public static function createFromEntity($entity): self
    {
        if (!($entity instanceof Entity)) {
            throw new InvalidArgumentException(
                printf('Parameter "entity" isn\'t an instance of "%s" class', Entity::class)
            );
        }

        return new self($entity->getId(), $entity->getAmount(), $entity->getIngredient());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getIngredient(): ?string
    {
        return $this->ingredient;
    }

    public function getIngredientDescription(): ?string
    {
        return $this->ingredientDescription;
    }
}
