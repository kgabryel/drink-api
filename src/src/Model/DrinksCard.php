<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;

class DrinksCard
{
    private ?string $name;
    private ?bool $active;
    private ArrayCollection $availableTags;
    private ArrayCollection $excludedTags;
    private ArrayCollection $availableIngredients;
    private ArrayCollection $excludedIngredients;
    private ArrayCollection $availableDrinks;
    private ArrayCollection $excludedDrinks;

    public function __construct()
    {
        $this->name = null;
        $this->active = null;
        $this->availableTags = new ArrayCollection();
        $this->excludedTags = new ArrayCollection();
        $this->availableIngredients = new ArrayCollection();
        $this->excludedIngredients = new ArrayCollection();
        $this->availableDrinks = new ArrayCollection();
        $this->excludedDrinks = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function getAvailableTags(): ArrayCollection
    {
        return $this->availableTags;
    }

    public function setAvailableTags(ArrayCollection $availableTags): void
    {
        $this->availableTags = $availableTags;
    }

    public function getExcludedTags(): ArrayCollection
    {
        return $this->excludedTags;
    }

    public function setExcludedTags(ArrayCollection $excludedTags): void
    {
        $this->excludedTags = $excludedTags;
    }

    public function getAvailableIngredients(): ArrayCollection
    {
        return $this->availableIngredients;
    }

    public function setAvailableIngredients(ArrayCollection $availableIngredients): void
    {
        $this->availableIngredients = $availableIngredients;
    }

    public function getExcludedIngredients(): ArrayCollection
    {
        return $this->excludedIngredients;
    }

    public function setExcludedIngredients(ArrayCollection $excludedIngredients): void
    {
        $this->excludedIngredients = $excludedIngredients;
    }

    public function getAvailableDrinks(): ArrayCollection
    {
        return $this->availableDrinks;
    }

    public function setAvailableDrinks(ArrayCollection $availableDrinks): void
    {
        $this->availableDrinks = $availableDrinks;
    }

    public function getExcludedDrinks(): ArrayCollection
    {
        return $this->excludedDrinks;
    }

    public function setExcludedDrinks(ArrayCollection $excludedDrinks): void
    {
        $this->excludedDrinks = $excludedDrinks;
    }
}
