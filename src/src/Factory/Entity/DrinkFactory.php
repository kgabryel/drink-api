<?php

namespace App\Factory\Entity;

use App\Entity\Drink;
use App\Model\Drink as DrinkModel;
use App\Service\DrinkFillService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class DrinkFactory extends EntityFactory
{
    private DrinkFillService $drinkFillService;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserService $userService,
        DrinkFillService $drinkFillService
    ) {
        parent::__construct($entityManager, $userService);
        $this->drinkFillService = $drinkFillService;
    }

    public function create(FormInterface $form, Request $request): ?Drink
    {
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return null;
        }
        /** @var DrinkModel $data */
        $data = $form->getData();
        $drink = new Drink();
        $drink->setUser($this->user);
        $drink->setPublicId(Uuid::uuid4()->toString());
        $this->drinkFillService->setDrink($drink)->setData($data)->fillDrinkBasicData();
        $this->saveEntity($drink);
        $this->drinkFillService->assignTags()->assignPositions();
        $this->saveEntity($drink);

        return $drink;
    }
}
