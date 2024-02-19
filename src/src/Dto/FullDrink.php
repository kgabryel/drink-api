<?php

namespace App\Dto;

use App\Entity\Drink as Entity;
use App\Entity\DrinkPosition;
use App\Entity\Photo as PhotoEntity;
use App\Entity\Tag;
use InvalidArgumentException;

class FullDrink implements DtoInterface
{
    private int $id;
    private string $name;
    private ?string $description;
    private array $positions;
    private array $tags;
    private array $photos;

    public function __construct(
        int $id,
        string $name,
        ?string $description,
        array $positions,
        array $tags,
        array $photos
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->positions = array_map(
            static fn(DrinkPosition $position): FullDrinkPosition => FullDrinkPosition::createFromEntity($position),
            $positions
        );
        $this->tags = array_map(
            static fn(Tag $tag): string => $tag->getName(),
            array_filter($tags, static fn(Tag $tag) => $tag->isPublic())
        );
        $this->photos = array_map(
            static fn(PhotoEntity $photo): Photo => Photo::createFromEntity($photo),
            $photos
        );
    }

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
            $entity->getDescription(),
            array_values($entity->getDrinkPositions()->toArray()),
            array_values($entity->getTag()->toArray()),
            array_values($entity->getPhotos()->toArray())
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}
