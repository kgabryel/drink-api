<?php

namespace App\Controller;

use App\Dto\Drink;
use App\Factory\Entity\PhotoFactory;
use App\Form\PhotoForm;
use App\Repository\DrinkRepository;
use App\Repository\PhotoRepository;
use App\Service\Entity\DrinkService;
use App\Service\Entity\PhotoService;
use App\Service\SerializeService;
use App\Utils\PhotoUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class PhotosController extends BaseController
{
    private SerializeService $serializer;

    public function __construct()
    {
        $this->serializer = SerializeService::getInstance(Drink::class);
    }

    public function show(
        string $type,
        int $photoId,
        PhotoRepository $photoRepository,
        KernelInterface $kernel,
        DrinkRepository $drinkRepository
    ): Response {
        $photo = $photoRepository->find($photoId);
        if ($photo === null) {
            return new Response(null, Response::HTTP_FORBIDDEN);
        }
        if (!PhotoService::checkAccess($photo, $this->getUser(), $drinkRepository)) {
            return new Response(null, Response::HTTP_FORBIDDEN);
        }
        $response = new Response();
        $response->headers->set('Content-Type', $photo->getType());
        $response->setContent(
            (string)file_get_contents(PhotoUtils::getPath($kernel->getProjectDir(), $type, $photo->getFileName()))
        );

        return $response;
    }

    public function store(int $id, DrinkService $drinkService, PhotoFactory $photoFactory, Request $request): Response
    {
        if (!$drinkService->find($id)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PhotoForm::class, null, [
            'method' => Request::METHOD_POST
        ]);
        $photo = $photoFactory->create($form, $request, $drinkService->getDrink());
        if ($photo === false) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        return new Response($this->serializer->serialize($drinkService->getDrink()), Response::HTTP_OK);
    }

    public function destroy(int $photoId, PhotoService $photoService): Response
    {
        if (!$photoService->find($photoId)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        $drink = $photoService->getPhoto()->getDrink();
        $photoService->remove();

        return new Response($this->serializer->serialize($drink), Response::HTTP_OK);
    }

    public function reorderPhotos(int $id, DrinkService $drinkService, Request $request): Response
    {
        if (!$drinkService->find($id)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }
        $drinkService->reorderPhotos($request);

        return new Response($this->serializer->serialize($drinkService->getDrink()), Response::HTTP_OK);
    }
}
