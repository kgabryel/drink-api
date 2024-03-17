<?php

namespace App\Service\Entity;

use App\Entity\DrinksCard;
use App\Model\DrinksCard as DrinksCardModel;
use App\Repository\DrinksCardRepository;
use App\Service\DrinksCardFillService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class DrinksCardService extends EntityService
{
    private DrinksCard $drinksCard;
    private DrinksCardRepository $drinksCardRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserService $userService,
        DrinksCardRepository $drinksCardRepository
    ) {
        parent::__construct($entityManager, $userService);
        $this->drinksCardRepository = $drinksCardRepository;
    }

    public function find(int $id): bool
    {
        $drinksCard = $this->drinksCardRepository->findById($id, $this->user);
        if ($drinksCard === null) {
            return false;
        }
        $this->drinksCard = $drinksCard;

        return true;
    }

    public function remove(): void
    {
        $this->removeEntity($this->drinksCard);
    }

    public function getDrinksCard(): DrinksCard
    {
        return $this->drinksCard;
    }

    public function activate(): void
    {
        $this->drinksCard->setActive(true);
        $this->saveEntity($this->drinksCard);
    }

    public function deactivate(): void
    {
        $this->drinksCard->setActive(false);
        $this->saveEntity($this->drinksCard);
    }

    public function update(FormInterface $form, Request $request): bool
    {
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return false;
        }
        /** @var DrinksCardModel $data */
        $data = $form->getData();
        $drinksCardFillService = new DrinksCardFillService($this->drinksCard, $data);
        $drinksCardFillService->fillData();
        $this->saveEntity($this->drinksCard);

        $this->entityManager->flush();

        return true;
    }
}
