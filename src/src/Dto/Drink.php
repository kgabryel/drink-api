<?php

namespace App\Dto;

use App\Entity\Drink as Entity;
use App\Entity\DrinkPosition as Position;
use App\Entity\Photo as PhotoEntity;
use App\Entity\Tag;
use InvalidArgumentException;

class Drink implements DtoInterface
{
    private int $id;
    private string $name;
    private ?string $description;
    private array $positions;
    private array $tags;
    private bool $favourite;
    private bool $public;
    private string $publicId;
    private array $photos;

    public function __construct(
        int $id,
        string $name,
        bool $favourite,
        bool $public,
        ?string $description,
        array $positions,
        array $tags,
        string $publicId,
        array $photos
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->favourite = $favourite;
        $this->public = $public;
        $this->positions = array_map(
            static fn(Position $position): DrinkPosition => DrinkPosition::createFromEntity($position),
            $positions
        );
        $this->tags = array_map(static fn(Tag $tag): int => $tag->getId(), $tags);
        $this->publicId = $publicId;
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
            $entity->isFavourite(),
            $entity->isPublic(),
            $entity->getDescription(),
            array_values($entity->getDrinkPositions()->toArray()),
            $entity->getTag()->toArray(),
            $entity->getPublicId(),
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

    public function isFavourite(): bool
    {
        return $this->favourite;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPublicId(): string
    {
        return $this->publicId;
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
