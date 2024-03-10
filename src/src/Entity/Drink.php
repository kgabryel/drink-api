<?php

namespace App\Entity;

use App\Repository\DrinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DrinkRepository::class)
 */
class Drink
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
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;
    /**
     * @ORM\OneToMany(targetEntity=DrinkPosition::class, mappedBy="drink", orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private Collection $drinkPositions;
    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="drinks")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private Collection $tags;
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="drinks")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $favourite;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $public;

    /**
     * @ORM\Column(type="string", length=128, unique=true))
     */
    private string $publicId;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="drink", orphanRemoval=true)
     * @ORM\OrderBy({"photoOrder" = "ASC"})
     */
    private Collection $photos;

    public function __construct()
    {
        $this->drinkPositions = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->photos = new ArrayCollection();
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
        $this->name = ucwords($name);

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
            $drinkPosition->setDrink($this);
        }

        return $this;
    }

    public function removeDrinkPosition(DrinkPosition $drinkPosition): self
    {
        $this->drinkPositions->removeElement($drinkPosition);

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

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

    public function isFavourite(): bool
    {
        return $this->favourite;
    }

    public function setFavourite(bool $favourite): self
    {
        $this->favourite = $favourite;

        return $this;
    }

    public function clearTags(): void
    {
        $this->tags = new ArrayCollection();
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getPublicId(): string
    {
        return $this->publicId;
    }

    public function setPublicId(string $publicId): self
    {
        $this->publicId = $publicId;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setDrink($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getDrink() === $this) {
                $photo->setDrink(null);
            }
        }

        return $this;
    }
}
