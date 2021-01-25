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
}
