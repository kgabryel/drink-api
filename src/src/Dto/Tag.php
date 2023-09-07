<?php

namespace App\Dto;

use App\Entity\Tag as Entity;
use InvalidArgumentException;

class Tag implements DtoInterface
{
    private int $id;
    private string $name;
    private int $drinksCount;

    public function __construct(int $id, string $name, int $drinksCount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->drinksCount = $drinksCount;
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

        return new self(
            $entity->getId(),
            $entity->getName(),
            $entity->getDrinks()->count()
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDrinksCount(): int
    {
        return $this->drinksCount;
    }
}
