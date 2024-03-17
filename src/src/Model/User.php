<?php

namespace App\Model;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User as UserEntity;
class User
{
    private ?string $email;
    private ?string $password;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getUser(UserPasswordEncoderInterface $passwordEncoder): UserEntity
    {
        $user = new UserEntity();
        $user->setEmail($this->email);
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $this->password
            )
        );

        return $user;
    }
}
