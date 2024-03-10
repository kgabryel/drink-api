<?php

namespace App\Controller;

use App\Dto\DrinksCard;
use App\Dto\FullDrink;
use App\Factory\Entity\DrinksCardFactory;
use App\Form\DrinksCardForm;
use App\Form\EditIngredientForm;
use App\Repository\DrinkRepository;
use App\Repository\DrinksCardRepository;
use App\Service\Entity\DrinksCardService;
use App\Service\SerializeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DrinksCardsController extends BaseController
{
    private SerializeService $serializer;

    public function __construct()
    {
        $this->serializer = SerializeService::getInstance(DrinksCard::class);
    }

    public function index(DrinksCardRepository $tagRepository): Response
    {
        return new Response($this->serializer->serializeArray($tagRepository->findForUser($this->getUser())));
    }
    public function store(DrinksCardFactory $drinksCardFactory, Request $request): Response
    {
        $form = $this->createForm(DrinksCardForm::class);
        $drinksCard = $drinksCardFactory->create($form, $request);
        if ($drinksCard === null) {
            return $this->returnErrors($form);
        }

        return new Response($this->serializer->serialize($drinksCard));
    }

    public function show(string $id, DrinkRepository $drinkRepository, DrinksCardRepository $cardRepository): Response
    {
        $serializer = SerializeService::getInstance(FullDrink::class);
        $drinksCard = $cardRepository->findOneBy([
            'publicId' => $id
        ]);
        if($drinksCard === null) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        if(!$drinksCard->isActive()) {
            return new Response(null, Response::HTTP_LOCKED);
        }
        return new Response($serializer->serializeArray($drinkRepository->findForCard($id)));
    }

    public function destroy(int $id, DrinksCardService $drinksCardService): Response
    {
        if (!$drinksCardService->find($id)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        $drinksCardService->remove();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    public function activate(int $id, DrinksCardService $drinksCardService): Response
    {
        if (!$drinksCardService->find($id)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        $drinksCardService->activate();

        return new Response($this->serializer->serialize($drinksCardService->getDrinksCard()), Response::HTTP_OK);
    }

    public function deactivate(int $id, DrinksCardService $drinksCardService): Response
    {
        if (!$drinksCardService->find($id)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        $drinksCardService->deactivate();

        return new Response($this->serializer->serialize($drinksCardService->getDrinksCard()), Response::HTTP_OK);
    }

    public function update(int $id, Request $request, DrinksCardService $drinksCardService): Response
    {
        if (!$drinksCardService->find($id)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(DrinksCardForm::class, null, [
            self::METHOD => Request::METHOD_PUT
        ]);
        if (!$drinksCardService->update($form, $request)) {
            return $this->returnErrors($form);
        }

        return new Response($this->serializer->serialize($drinksCardService->getDrinksCard()), Response::HTTP_OK);
    }
}