<?php

namespace App\Controller;

use App\Dto\Drink;
use App\Dto\FullDrink;
use App\Factory\Entity\DrinkFactory;
use App\Form\DrinkForm;
use App\Repository\DrinkRepository;
use App\Service\Entity\DrinkService;
use App\Service\Entity\PhotoService;
use App\Service\SerializeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DrinksController extends BaseController
{
    private SerializeService $serializer;

    public function __construct()
    {
        $this->serializer = SerializeService::getInstance(Drink::class);
    }

    public function index(DrinkRepository $drinkRepository): Response
    {
        return new Response($this->serializer->serializeArray($drinkRepository->findForUser($this->getUser())));
    }

    public function store(DrinkFactory $drinkFactory, Request $request): Response
    {
        $form = $this->createForm(DrinkForm::class);
        $drink = $drinkFactory->create($form, $request);
        if ($drink === null) {
            return $this->returnErrors($form);
        }

        return new Response($this->serializer->serialize($drink));
    }

    public function modify(int $id, Request $request, DrinkService $drinkService): Response
    {
        if (!$drinkService->find($id)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(DrinkForm::class, null, [
            self::METHOD => Request::METHOD_PATCH
        ]);
        if (!$drinkService->modify($form, $request)) {
            return $this->returnErrors($form);
        }

        return new Response($this->serializer->serialize($drinkService->getDrink()), Response::HTTP_OK);
    }

    public function update(int $id, Request $request, DrinkService $drinkService): Response
    {
        if (!$drinkService->find($id)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(DrinkForm::class, null, [
            self::METHOD => Request::METHOD_PUT
        ]);
        if (!$drinkService->update($form, $request)) {
            return $this->returnErrors($form);
        }

        return new Response($this->serializer->serialize($drinkService->getDrink()), Response::HTTP_OK);
    }

    public function destroy(int $id, DrinkService $drinkService, PhotoService $photoService): Response
    {
        if (!$drinkService->find($id)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        $drinkService->remove($photoService);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    public function public(string $id, DrinkRepository $drinkRepository): Response
    {
        $drink = $drinkRepository->findOneBy([
            'public' => true,
            'publicId' => $id
        ]);
        if ($drink === null) {
            return new Response(null, Response::HTTP_FORBIDDEN);
        }
        $serializer = SerializeService::getInstance(FullDrink::class);

        return new Response($serializer->serialize($drink), Response::HTTP_OK);
    }
}
