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
     * @return JsonResponse
     */
    public function getCardGame(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->cardGameService->createCardGame($request)
        );
    }
}