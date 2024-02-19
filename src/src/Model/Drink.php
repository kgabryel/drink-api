<?php

namespace App\Model;

class Drink
{
    private ?string $name;
    private ?string $description;
    /** @var string[] */
    private array $tags;
    /**
     * @var DrinkPosition[]
     */
    private array $positions;
    private ?bool $favourite;
    private ?bool $public;

    public function __construct()
    {
        $this->name = null;
        $this->description = null;
        $this->tags = [];
        $this->positions = [];
        $this->favourite = null;
        $this->public = null;
    }

    public function isFavourite(): ?bool
    {
        return $this->favourite;
    }

    public function setFavourite(?bool $favourite): void
    {
        $this->favourite = $favourite;
    }

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function setPositions(array $positions): void
    {
        $this->positions = $positions;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTags(): array
    {
        return array_unique($this->tags);
    }

    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(?bool $public): void
    {
        $this->public = $public;
    }
}
