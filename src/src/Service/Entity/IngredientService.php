<?php

namespace App\Service\Entity;

use App\Entity\Ingredient;
use App\Model\Ingredient as IngredientModel;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class IngredientService extends EntityService
{
    private Ingredient $ingredient;
    private IngredientRepository $ingredientRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        IngredientRepository $ingredientRepository
    ) {
        parent::__construct($entityManager, $tokenStorage);
        $this->ingredientRepository = $ingredientRepository;
    }

    public function find(int $id): bool
    {
        $ingredient = $this->ingredientRepository->findById($id, $this->user);
        if ($ingredient === null) {
            return false;
        }
        $this->ingredient = $ingredient;

        return true;
    }

    public function findByOzaId(int $id): bool
    {
        $this->ingredient = $this->ingredientRepository->findOneBy([
            'ozaId' => $id,
            'user' => $this->user
        ]);

        return $this->ingredient !== null;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    public function update(FormInterface $form, Request $request): bool
    {
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }
        /** @var IngredientModel $data */
        $data = $form->getData();
        $name = $data->getName();
        $description = $data->getDescription();
        $available = $data->isAvailable();
        $ozaId = $data->getOzaId();
        if ($name !== null) {
            $this->ingredient->setName($name);
        }
        if ($description !== null) {
            $this->ingredient->setDescription($description);
        }
        if ($ozaId !== null) {
            if ($ozaId === 0) {
                $ozaId = null;
            }
            $this->ingredient->setOzaId($ozaId);
        }
        if ($available !== null) {
            $this->ingredient->setAvailable($available);
        }
        $this->saveEntity($this->ingredient);

        return true;
    }

    public function remove(): void
    {
        $this->removeEntity($this->ingredient);
    }

    public function disconnectFromOZA(): void
    {
        $this->ingredient->setOzaId(null);
        $this->saveEntity($this->ingredient);
    }

    public function updateAvailable(bool $available): void
    {
        $this->ingredient->setAvailable($available);
        $this->saveEntity($this->ingredient);
    }

    public function clearOzaKeys(): void
    {
        /** @var Ingredient $ingredient */
        foreach ($this->ingredientRepository->findForUser($this->user) as $ingredient) {
            $ingredient->setOzaId(null);
            $this->saveEntity($ingredient);
        }
    }

    public function getFirstIngredientWithOza(): ?Ingredient
    {
        return $this->ingredientRepository->findFirstIngredientWithOza($this->user);
    }
}
