<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\OneToMany(targetEntity=Tag::class, mappedBy="user", orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private Collection $tags;

    /**
     * @ORM\OneToMany(targetEntity=Ingredient::class, mappedBy="user", orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private Collection $ingredients;

    /**
     * @ORM\OneToMany(targetEntity=Drink::class, mappedBy="user", orphanRemoval=true)
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private Collection $drinks;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private ?string $fbId;

    /**
     * @ORM\OneToOne(targetEntity=Settings::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private Settings $settings;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="user", orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private Collection $photos;

    /**
     * @ORM\OneToMany(targetEntity=DrinksCard::class, mappedBy="user", orphanRemoval=true)
     */
    private Collection $drinksCards;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->drinks = new ArrayCollection();
        $this->roles = [];
        $this->photos = new ArrayCollection();
        $this->drinksCards = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setUser($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->setUser($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    /**
     * @return Collection|Drink[]
     */
    public function getDrinks(): Collection
    {
        return $this->drinks;
    }

    public function addDrink(Drink $drink): self
    {
        if (!$this->drinks->contains($drink)) {
            $this->drinks[] = $drink;
            $drink->setUser($this);
        }

        return $this;
    }

    public function removeDrink(Drink $drink): self
    {
        $this->drinks->removeElement($drink);

        return $this;
    }

    public function getFbId(): ?string
    {
        return $this->fbId;
    }

    public function setFbId(?string $fbId): self
    {
        $this->fbId = $fbId;

        return $this;
    }

    public function getSettings(): Settings
    {
        return $this->settings;
    }

    public function setSettings(Settings $settings): self
    {
        // set the owning side of the relation if necessary
        if ($settings->getUser() !== $this) {
            $settings->setUser($this);
        }

        $this->settings = $settings;

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
            $photo->setUser($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        $this->photos->removeElement($photo);

        return $this;
    }

    /**
     * @return Collection<int, DrinksCard>
     */
    public function getDrinksCards(): Collection
    {
        return $this->drinksCards;
    }

    public function addDrinksCard(DrinksCard $drinksCard): self
    {
        if (!$this->drinksCards->contains($drinksCard)) {
            $this->drinksCards[] = $drinksCard;
            $drinksCard->setUser($this);
        }

        return $this;
    }

    public function removeDrinksCard(DrinksCard $drinksCard): self
    {
        $this->drinksCards->removeElement($drinksCard);

        return $this;
    }
}
