<?php

declare(strict_types=1);


namespace App\Tests\api;


use Symfony\Component\HttpFoundation\Response;

class CardGameCest
{
    public function checkFullCardGame(\ApiTester $I)
    {
        $I->wantTo("create the card game and check the number of cards");
        //full card game
        $I->sendGet('/cardgame');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->assertEquals(52, count(json_decode($I->grabResponse())));

        //card game without facecard
        $I->sendGet('/cardgame',
            [
                'withCardFace' => false,
                'aceIsFaceCard' => false
            ]);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->assertEquals(40, count(json_decode($I->grabResponse())));

        //card game with 7 is the first card in a color
        $I->sendGet('/cardgame',
            [
                'firstValue' => 7
            ]);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->assertEquals(32, count(json_decode($I->grabResponse())));

    }

    public function countNumberOfCard(\ApiTester $I)
    {
        $I->wantTo("call route for have a not sort hand and check number of card");
        $I->sendGet('/cardgame/not-sort');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->assertEquals(10, count(json_decode($I->grabResponse())));

        $I->sendGet('/cardgame/not-sort',
            [
                'firstValue' => 7,
                'lastValue' => 8,
                'withCardFace' => false
            ]);

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }
}
