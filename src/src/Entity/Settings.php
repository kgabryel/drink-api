<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="settings", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private ?string $ozaKey;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $onlyAvailable;

    public function getId(): int
    {
        return $this->id;
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

    public function getOzaKey(): ?string
    {
        return $this->ozaKey;
    }

    public function setOzaKey(?string $ozaKey): self
    {
        $this->ozaKey = $ozaKey;

        return $this;
    }

    public function getOnlyAvailable(): bool
    {
        return $this->onlyAvailable;
    }

    public function setOnlyAvailable(bool $onlyAvailable): self
    {
        $this->onlyAvailable = $onlyAvailable;

        return $this;
    }
}
