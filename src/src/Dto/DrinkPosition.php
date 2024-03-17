<?php

namespace App\Dto;

use App\Entity\DrinkPosition as Entity;
use App\Entity\Ingredient;
use InvalidArgumentException;

class DrinkPosition implements DtoInterface
{
    private int $id;
    private ?string $amount;
    private int $ingredientId;

    public function __construct(int $id, ?string $amount, Ingredient $ingredient)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->ingredientId = $ingredient->getId();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  Entity  $entity
     *
     * @return self
     */
    public static function createFromEntity(mixed $entity): self
    {
        if (!($entity instanceof Entity)) {
            throw new InvalidArgumentException(
                sprintf('Parameter "entity" isn\'t an instance of "%s" class', Entity::class)
            );
        }

        return new self($entity->getId(), $entity->getAmount(), $entity->getIngredient());
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function getIngredientId(): ?int
    {
        return $this->ingredientId;
    }
}
