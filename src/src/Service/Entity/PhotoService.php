<?php

namespace App\Service\Entity;

use App\Config\PhotoType;
use App\Entity\Photo;
use App\Entity\User;
use App\Repository\DrinkRepository;
use App\Repository\PhotoRepository;
use App\Service\UserService;
use App\Utils\PhotoUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class PhotoService extends EntityService
{
    private Filesystem $filesystem;
    private KernelInterface $kernel;
    private Photo $photo;
    private PhotoRepository $photoRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserService $userService,
        PhotoRepository $photoRepository,
        Filesystem $filesystem,
        KernelInterface $kernel
    ) {
        parent::__construct($entityManager, $userService);
        $this->photoRepository = $photoRepository;
        $this->filesystem = $filesystem;
        $this->kernel = $kernel;
    }

    public static function checkAccess(Photo $photo, ?User $user, DrinkRepository $drinkRepository): bool
    {
        $drink = $photo->getDrink();
        if ($drink->isPublic()) {
            return true;
        }
        $photoUser = $photo->getUser();
        if ($photoUser->getId() === $user?->getId()) {
            return true;
        }

        return $drinkRepository->existsInCard($drink->getId());
    }

    public function set(Photo $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function find(int $id): bool
    {
        $photo = $this->photoRepository->findById($id, $this->user);

        if ($photo === null) {
            return false;
        }
        $this->photo = $photo;

        return true;
    }

    public function getPhoto(): Photo
    {
        return $this->photo;
    }

    public function remove(): void
    {
        $fileName = $this->photo->getFileName();
        $this->removeEntity($this->photo);
        foreach (array_column(PhotoType::cases(), 'value') as $type) {
            $this->filesystem->remove(PhotoUtils::getPath($this->kernel->getProjectDir(), $type, $fileName));
        }
    }
}
