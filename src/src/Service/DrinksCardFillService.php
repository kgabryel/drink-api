<?php

namespace App\Service;

use App\Entity\Drink;
use App\Entity\DrinksCard;
use App\Entity\Ingredient;
use App\Entity\Tag;
use App\Model\DrinksCard as DrinksCardModel;

class DrinksCardFillService
{
    private DrinksCard $drinksCard;
    private DrinksCardModel $data;

    public function __construct(DrinksCard $drinksCard, DrinksCardModel $data)
    {
        $this->drinksCard = $drinksCard;
        $this->data = $data;
    }

    public function fillData(): static
    {
        $this->drinksCard->setName($this->data->getName());
        $this->drinksCard->setActive($this->data->isActive() ?? false);
        $availableTags = $this->data->getAvailableTags();
        $excludedTags = $this->data->getExcludedTags();
        $availableIngredients = $this->data->getAvailableIngredients();
        $excludedIngredients = $this->data->getExcludedIngredients();
        $availableDrinks = $this->data->getAvailableDrinks();
        $excludedDrinks = $this->data->getExcludedDrinks();
        $this->drinksCard->setAvailableTags(
            $availableTags->filter(static fn(Tag $tag) => !$excludedTags->contains($tag))
        );
        $this->drinksCard->setExcludedTags($excludedTags);
        $this->drinksCard->setAvailableIngredients(
            $availableIngredients->filter(
                static fn(Ingredient $ingredient) => !$excludedIngredients->contains($ingredient)
            )
        );
        $this->drinksCard->setExcludedIngredients($excludedIngredients);
        $this->drinksCard->setAvailableDrinks(
            $availableDrinks->filter(static fn(Drink $drink) => !$excludedDrinks->contains($drink))
        );
        $this->drinksCard->setExcludedDrinks($excludedDrinks);

        return $this;
    }
}
