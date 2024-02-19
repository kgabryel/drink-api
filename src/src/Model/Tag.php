<?php

namespace App\Model;

class Tag
{
    private ?string $name;
    private ?bool $public;

    public function __construct()
    {
        $this->name = null;
        $this->public = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(?bool $public): void
    {
        $this->public = $public;
    }
}
