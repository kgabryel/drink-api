<?php

namespace App\Entity;

use App\Repository\DrinkPositionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DrinkPositionRepository::class)
 */
class DrinkPosition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Drink::class, inversedBy="drinkPositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private Drink $drink;

    /**
     * @ORM\ManyToOne(targetEntity=Ingredient::class, inversedBy="drinkPositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private Ingredient $ingredient;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $amount;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDrink(): Drink
    {
        return $this->drink;
    }

    public function setDrink(Drink $drink): self
    {
        $this->drink = $drink;

        return $this;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(?string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
