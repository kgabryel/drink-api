<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $height;

    /**
     * @ORM\Column(type="integer")
     */
    private int $width;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private string $fileName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Drink::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private Drink $drink;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $photoOrder;

    public function getId(): int
    {
        return $this->id;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getDrink(): Drink
    {
        return $this->drink;
    }

    public function setDrink(Drink $drink): self
    {
        $this->drink = $drink;

        return $this;
    }

    public function getPhotoOrder(): ?int
    {
        return $this->photoOrder;
    }

    public function setPhotoOrder(?int $photoOrder): self
    {
        $this->photoOrder = $photoOrder;

        return $this;
    }
}
