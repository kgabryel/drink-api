<?php

namespace App\Service;

use App\Entity\Drink;
use App\Entity\DrinkPosition;
use App\Entity\Tag;
use App\Entity\User;
use App\Model\Drink as DrinkModel;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DrinkFillService
{
    private EntityManagerInterface $entityManager;
    private TagRepository $tagRepository;
    private User $user;
    private Drink $drink;
    private DrinkModel $data;

    public function __construct(
        EntityManagerInterface $entityManager,
        TagRepository $tagRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->entityManager = $entityManager;
        $this->tagRepository = $tagRepository;
        $this->user = $tokenStorage->getToken()->getUser();
    }

    public function setDrink(Drink $drink): static
    {
        $this->drink = $drink;

        return $this;
    }

    public function setData(DrinkModel $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function fillDrinkBasicData(): static
    {
        $this->drink->setName($this->data->getName());
        $this->drink->setFavourite($this->data->isFavourite() ?? false);
        $this->drink->setPublic($this->data->isPublic() ?? false);
        $this->drink->setDescription($this->data->getDescription());

        return $this;
    }

    public function assignTags(): static
    {
        foreach ($this->data->getTags() as $tag) {
            $tagEntity = $this->tagRepository->findOneBy([
                'name' => $tag,
                'user' => $this->user
            ]);
            if ($tagEntity === null) {
                $tagEntity = new Tag();
                $tagEntity->setName($tag);
                $tagEntity->setUser($this->user);
                $this->entityManager->persist($tagEntity);
            }
            $this->drink->addTag($tagEntity);
        }

        return $this;
    }

    public function assignPositions(): static
    {
        foreach ($this->data->getPositions() as $position) {
            $positionEntity = new DrinkPosition();
            $positionEntity->setIngredient($position->getIngredient());
            $positionEntity->setAmount($position->getAmount());
            $this->drink->addDrinkPosition($positionEntity);
            $this->entityManager->persist($positionEntity);
        }

        return $this;
    }
}
