<?php

namespace App\Factory\Entity;

use App\Entity\Drink;
use App\Entity\DrinksCard;
use App\Entity\Ingredient;
use App\Entity\Tag;
use App\Model\DrinksCard as DrinksCardModel;
use App\Service\DrinksCardFillService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class DrinksCardFactory extends EntityFactory
{
    public function create(FormInterface $form, Request $request): ?DrinksCard
    {
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return null;
        }
        /** @var DrinksCardModel $data */
        $data = $form->getData();
        $drinksCard = new DrinksCard();
        $drinksCard->setUser($this->user);
        $drinksCard->setPublicId(Uuid::uuid4()->toString());
        $drinksCardFillService = new DrinksCardFillService($drinksCard, $data);
        $drinksCardFillService->fillData();
        $this->saveEntity($drinksCard);

        return $drinksCard;
    }
}
