<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CardGameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  @Route("/cardgame", name="api_cardgame_")
 */
class CardGameController extends AbstractController
{

    public CardGameService $cardGameService;

    public function __construct(CardGameService $cardGameService)
    {
        $this->cardGameService = $cardGameService;
    }

    /**
     *
     * @Route(name="full", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCardGame(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->cardGameService->createCardGame($request)
        );
    }

    /**
     *
     * @Route("/not-sort", name="cardgame_not_sort", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getNotSortHand(Request $request): JsonResponse
    {
        if ($request->query->getInt('firstValue') && $request->query->getInt('lastValue') &&
        $request->query->getBoolean('withCardFace') === false
        && ($request->query->getInt('lastValue') - $request->query->getInt('firstValue') <= 1)
        ) {
            return new JsonResponse(
                [],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            $this->cardGameService->flushAndDraw($request)
        );
    }

    /**
     *
     * @Route("/sort", name="cardgame_sort", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSortHand(Request $request): JsonResponse
    {
        if ($request->query->getInt('firstValue') && $request->query->getInt('lastValue') &&
            $request->query->getBoolean('withCardFace') === false
            && ($request->query->getInt('lastValue') - $request->query->getInt('firstValue') <= 1)
        ) {
            return new JsonResponse(
                [],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            $this->cardGameService->flushDrawAndSort($request)
        );
    }
}