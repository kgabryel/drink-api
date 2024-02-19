<?php

namespace App\Service\Entity;

use App\Entity\Drink;
use App\Model\Drink as DrinkModel;
use App\Repository\DrinkRepository;
use App\Service\DrinkFillService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DrinkService extends EntityService
{
    private Drink $drink;
    private DrinkFillService $drinkFillService;
    private DrinkRepository $drinkRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        DrinkFillService $drinkFillService,
        DrinkRepository $drinkRepository
    ) {
        parent::__construct($entityManager, $tokenStorage);
        $this->drinkFillService = $drinkFillService;
        $this->drinkRepository = $drinkRepository;
    }

    public function find(int $id): bool
    {
        $drink = $this->drinkRepository->findById($id, $this->user);
        if ($drink === null) {
            return false;
        }
        $this->drink = $drink;

        return true;
    }

    public function getDrink(): Drink
    {
        return $this->drink;
    }

    public function modify(FormInterface $form, Request $request): bool
    {
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }
        /** @var DrinkModel $data */
        $data = $form->getData();
        $name = $data->getName();
        $favourite = $data->isFavourite();
        $description = $data->getDescription();
        if ($name !== null) {
            $this->drink->setName($name);
        }
        if ($favourite !== null) {
            $this->drink->setFavourite($favourite);
        }
        if ($description !== null) {
            $this->drink->setDescription($description);
        }
        $this->saveEntity($this->drink);

        return true;
    }

    public function update(FormInterface $form, Request $request): bool
    {
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }
        /** @var DrinkModel $data */
        $data = $form->getData();
        $this->drinkFillService->setDrink($this->drink)->setData($data)->fillDrinkBasicData();
        $this->saveEntity($this->drink);
        $this->drink->clearTags();
        $this->saveEntity($this->drink);
        $this->drinkFillService->assignTags();
        foreach ($this->drink->getDrinkPositions() as $position) {
            $this->removeEntity($position);
        }
        $this->drinkFillService->assignPositions();
        $this->entityManager->flush();

        return true;
    }

    public function remove(PhotoService $photoService): void
    {
        foreach ($this->drink->getPhotos() as $photo) {
            $photoService->set($photo)->remove();
        }
        $this->removeEntity($this->drink);
    }

    public function reorderPhotos(Request $request): void
    {
        $order = $request->get('order') ?? [];
        if (!is_array($order)) {
            return;
        }
        $photosOrder = [];
        foreach ($order as $item) {
            $photosOrder[(int)($item['id'] ?? 0)] = (int)($item['index'] ?? 1);
        }
        foreach ($this->drink->getPhotos() as $photo) {
            $photo->setPhotoOrder($photosOrder[$photo->getId()] ?? 1);
            $this->saveEntity($photo);
        }
    }
}
