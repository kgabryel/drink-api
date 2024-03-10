<?php

namespace App\Entity;

use App\Repository\DrinksCardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DrinksCardRepository::class)
 */
class DrinksCard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="drinksCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $active;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private string $publicId;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class)
     * @ORM\JoinTable(name="drinks_cards_available_tags")
     */
    private Collection $availableTags;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class)
     * @ORM\JoinTable(name="drinks_cards_excluded_tags")
     */
    private Collection $excludedTags;

    /**
     * @ORM\ManyToMany(targetEntity=Ingredient::class)
     * @ORM\JoinTable(name="drinks_cards_available_ingredients")
     */
    private Collection $availableIngredients;

    /**
     * @ORM\ManyToMany(targetEntity=Ingredient::class)
     * @ORM\JoinTable(name="drinks_cards_excluded_ingredients")
     */
    private Collection $excludedIngredients;

    /**
     * @ORM\ManyToMany(targetEntity=Drink::class)
     * @ORM\JoinTable(name="drinks_cards_available_drinks")
     */
    private Collection $availableDrinks;

    /**
     * @ORM\ManyToMany(targetEntity=Drink::class)
     * @ORM\JoinTable(name="drinks_cards_excluded_drinks")
     */
    private Collection $excludedDrinks;

    public function __construct()
    {
        $this->availableTags = new ArrayCollection();
        $this->excludedTags = new ArrayCollection();
        $this->availableIngredients = new ArrayCollection();
        $this->excludedIngredients = new ArrayCollection();
        $this->availableDrinks = new ArrayCollection();
        $this->excludedDrinks = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    public function setPublicId(string $publicId): self
    {
        $this->publicId = $publicId;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getAvailableTags(): Collection
    {
        return $this->availableTags;
    }

    public function addAvailableTag(Tag $availableTag): self
    {
        if (!$this->availableTags->contains($availableTag)) {
            $this->availableTags[] = $availableTag;
        }

        return $this;
    }

    public function removeAvailableTag(Tag $availableTag): self
    {
        $this->availableTags->removeElement($availableTag);

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getExcludedTags(): Collection
    {
        return $this->excludedTags;
    }

    public function addExcludedTag(Tag $excludedTag): self
    {
        if (!$this->excludedTags->contains($excludedTag)) {
            $this->excludedTags[] = $excludedTag;
        }

        return $this;
    }

    public function removeExcludedTag(Tag $excludedTag): self
    {
        $this->excludedTags->removeElement($excludedTag);

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getAvailableIngredients(): Collection
    {
        return $this->availableIngredients;
    }

    public function addAvailableIngredient(Ingredient $availableIngredient): self
    {
        if (!$this->availableIngredients->contains($availableIngredient)) {
            $this->availableIngredients[] = $availableIngredient;
        }

        return $this;
    }

    public function removeAvailableIngredient(Ingredient $availableIngredient): self
    {
        $this->availableIngredients->removeElement($availableIngredient);

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getExcludedIngredients(): Collection
    {
        return $this->excludedIngredients;
    }

    public function addExcludedIngredient(Ingredient $excludedIngredient): self
    {
        if (!$this->excludedIngredients->contains($excludedIngredient)) {
            $this->excludedIngredients[] = $excludedIngredient;
        }

        return $this;
    }

    public function removeExcludedIngredient(Ingredient $excludedIngredient): self
    {
        $this->excludedIngredients->removeElement($excludedIngredient);

        return $this;
    }

    public function setAvailableTags(ArrayCollection $tags): self
    {
        $this->availableTags = $tags;

        return $this;
    }

    public function setExcludedTags(ArrayCollection $tags): self
    {
        $this->excludedTags = $tags;

        return $this;
    }

    public function setAvailableIngredients(ArrayCollection $ingredients): self
    {
        $this->availableIngredients = $ingredients;

        return $this;
    }

    public function setExcludedIngredients(ArrayCollection $ingredients): self
    {
        $this->excludedIngredients = $ingredients;

        return $this;
    }

    /**
     * @return Collection|Drink[]
     */
    public function getAvailableDrinks(): Collection
    {
        return $this->availableDrinks;
    }

    public function addAvailableDrink(Drink $availableDrink): self
    {
        if (!$this->availableDrinks->contains($availableDrink)) {
            $this->availableDrinks[] = $availableDrink;
        }

        return $this;
    }

    public function removeAvailableDrink(Drink $availableDrink): self
    {
        $this->availableDrinks->removeElement($availableDrink);

        return $this;
    }

    /**
     * @return Collection|Drink[]
     */
    public function getExcludedDrinks(): Collection
    {
        return $this->excludedDrinks;
    }

    public function addExcludedDrink(Drink $excludedDrink): self
    {
        if (!$this->excludedDrinks->contains($excludedDrink)) {
            $this->excludedDrinks[] = $excludedDrink;
        }

        return $this;
    }

    public function removeExcludedDrink(Drink $excludedDrink): self
    {
        $this->excludedDrinks->removeElement($excludedDrink);

        return $this;
    }

    public function setAvailableDrinks(ArrayCollection $drinks): self
    {
        $this->availableDrinks = $drinks;

        return $this;
    }

    public function setExcludedDrinks(ArrayCollection $drinks): self
    {
        $this->excludedDrinks = $drinks;

        return $this;
    }
}
