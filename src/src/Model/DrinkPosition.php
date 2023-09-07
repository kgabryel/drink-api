<?php

namespace App\Model;

use App\Entity\Ingredient;

class DrinkPosition
{
    private ?string $amount;
    private ?Ingredient $ingredient;

    public function __construct()
    {
        $this->amount = null;
        $this->ingredient = null;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(?string $amount): void
    {
        $this->amount = $amount;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): void
    {
        $this->ingredient = $ingredient;
    }
}
