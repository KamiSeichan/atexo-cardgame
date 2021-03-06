<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class CardGameService
{

    /**
     * @var array|string[]
     */
    public array $colors = ['spade', 'heard', 'diamond', 'club'];

    /**
     * @var array|string[]
     */
    public array $faceCard = ['jack', 'queen', 'king'];

    /**
     * @var int
     */
    public int $firstValue = 2;

    /**
     * @var int
     */
    public int $lastValue = 10;


    /**
     * @param Request $request
     * @return array
     */
    public function createCardGame(Request $request): array
    {
        if ($request->query->getBoolean('aceIsFaceCard', true) === true) {
            $this->faceCard[] = 'ace';
            $firstCardValue = $request->query->getInt('firstValue', $this->firstValue);
        } else {
            $firstCardValue = 1;
        }

        $lastCardValue = $request->query->getInt('lastValue', $this->lastValue);

        $cardGame = [];

        for ($i = 0; $i < count($this->colors); $i++) {
            for ($j = $firstCardValue; $j <= $lastCardValue; $j++) {
                $cardGame[] = [$j, $this->colors[$i]];
            }
            if ($request->query->getBoolean('withCardFace', true) === true) {
                for ($k = 0; $k < count($this->faceCard); $k++) {
                    $cardGame[] = [$this->faceCard[$k], $this->colors[$i]];
                }
            }
        }

        return $cardGame;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function flushAndDraw(Request $request): array
    {
        $cardGame = $this->createCardGame($request);
        shuffle($cardGame);
        $handCardKey = array_rand($cardGame, 10);

        return array_values(array_intersect_key($cardGame, array_flip($handCardKey)));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function flushDrawAndSort(Request $request): array
    {
        $cardGame = $shuffleCardGame = $this->createCardGame($request);
        shuffle($shuffleCardGame);
        $handCardKey = array_rand($shuffleCardGame, 10);

        return array_values(array_intersect_key($cardGame, array_flip($handCardKey)));
    }
}
