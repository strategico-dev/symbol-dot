<?php

use Codeception\Util\HttpCode;

class ShowContactCest
{
    /**
     * @param \ApiTester $I
     * @throws \Exception
     */
    function _before(\ApiTester $I)
    {
        $I->login();
    }

    /**
     * @param \ApiTester $I
     * @throws \Exception
     */
    public function successful(\ApiTester $I)
    {
        $dummyContact = $I->createDummyContact();
        $id = $dummyContact['id'];

        $I->sendGet("/api/v1/contacts/$id");

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    /**
     * @param \ApiTester $I
     * @throws \Exception
     */
    public function successfulList(\ApiTester $I)
    {
        $expectedSize = 3;
        for($i = 0; $i < $expectedSize; $i++)
        {
            $I->createDummyContact();
        }

        $I->sendGet("/api/v1/contacts");

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContains('data');
    }

    /**
     * @param \ApiTester $I
     */
    public function notFound(\ApiTester $I)
    {
        $notExistsId = -1;

        $I->sendGet("/api/v1/contacts/$notExistsId");

        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }
}
