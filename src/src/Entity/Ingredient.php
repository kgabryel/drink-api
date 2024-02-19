<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $available;

    /**
     * @ORM\OneToMany(targetEntity=DrinkPosition::class, mappedBy="ingredient", orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private Collection $drinkPositions;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ingredients")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $ozaId;

    public function __construct()
    {
        $this->drinkPositions = new ArrayCollection();
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

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    /**
     * @return Collection|DrinkPosition[]
     */
    public function getDrinkPositions(): Collection
    {
        return $this->drinkPositions;
    }

    public function addDrinkPosition(DrinkPosition $drinkPosition): self
    {
        if (!$this->drinkPositions->contains($drinkPosition)) {
            $this->drinkPositions[] = $drinkPosition;
            $drinkPosition->setIngredient($this);
        }

        return $this;
    }

    public function removeDrinkPosition(DrinkPosition $drinkPosition): self
    {
        $this->drinkPositions->removeElement($drinkPosition);

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOzaId(): ?int
    {
        return $this->ozaId;
    }

    public function setOzaId(?int $ozaId): self
    {
        $this->ozaId = $ozaId;

        return $this;
    }
}
