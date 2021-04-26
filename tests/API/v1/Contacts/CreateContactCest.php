<?php

use Codeception\Util\HttpCode;

class CreateContactCest
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
     */
    public function successful(\ApiTester $I)
    {
        $data = [
            'first_name' => 'Foo'
        ];

        $I->sendPost('/api/v1/contacts', $data);

        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseContains('first_name');
    }

    /**
     * @param \ApiTester $I
     */
    public function failedWithEmptyParams(\ApiTester $I)
    {
        $invalidData = [];

        $I->sendPost('/api/v1/contacts', $invalidData);

        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContains('errors');
    }

    /**
     * @param \ApiTester $I
     */
    public function failedWithBadFirstName(\ApiTester $I)
    {
        $invalidData = [
            'first_name' => 'A'
        ];

        $I->sendPost('/api/v1/contacts', $invalidData);

        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContains('errors');
    }

    /**
     * @param \ApiTester $I
     */
    public function failedWithBadEmail(\ApiTester $I)
    {
        $invalidData = [
            'first_name' => 'Foo',
            'email'      => 'Foo'
        ];

        $I->sendPost('/api/v1/contacts', $invalidData);

        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContains('errors');
    }
}
