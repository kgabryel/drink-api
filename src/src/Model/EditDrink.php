<?php

namespace App\Model;

class EditDrink
{
    private ?string $name;
    private ?string $description;
    private ?array $tags;
    private ?bool $favourite;

    public function __construct()
    {
        $this->name = null;
        $this->description = null;
        $this->tags = null;
        $this->favourite = null;
    }

    public function isFavourite(): ?bool
    {
        return $this->favourite;
    }

    public function setFavourite(?bool $favourite): void
    {
        $this->favourite = $favourite;
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

    public function getTags(): ?array
    {
        if ($this->tags === null) {
            return null;
        }

        return array_unique($this->tags);
    }

    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }
}
