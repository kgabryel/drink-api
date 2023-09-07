<?php

namespace App\Dto;

use App\Entity\DrinkPosition;
use App\Entity\Ingredient as Entity;
use InvalidArgumentException;

class Ingredient implements DtoInterface
{
    private int $id;
    private string $name;
    private ?string $description;
    private bool $available;
    private int $drinksCount;
    private ?int $ozaId;

    public function __construct(
        int $id,
        string $name,
        ?string $description,
        bool $available,
        int $drinksCount,
        ?int $ozaId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->available = $available;
        $this->drinksCount = $drinksCount;
        $this->ozaId = $ozaId;
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
        $drinks = array_map(
            static fn(DrinkPosition $position): int => $position->getDrink()->getId(),
            $entity->getDrinkPositions()->toArray()
        );

        return new self(
            $entity->getId(),
            $entity->getName(),
            $entity->getDescription(),
            $entity->isAvailable(),
            count(array_unique($drinks)),
            $entity->getOzaId()
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): void
    {
        $this->available = $available;
    }

    public function getOzaId(): ?int
    {
        return $this->ozaId;
    }

    public function getDrinksCount(): int
    {
        return $this->drinksCount;
    }
}
