<?php

use Codeception\Util\HttpCode;

class UpdateContactCest
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
     * @param ApiTester $I
     * @throws Exception
     */
    public function successful(\ApiTester $I)
    {
        $createdContact =$I->createDummyContact();
        $id = $createdContact['id'];
        $updatableData = ['first_name' => 'Bar'];

        $I->sendPut("/api/v1/contacts/$id", $updatableData);

        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
