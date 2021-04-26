<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

    /**
     * Define custom actions here
     */

    /**
     * @throws Exception
     */
    public function login()
    {
        $this->sendPost('/api/v1/auth/login', [
            'email'     => 'api-tester@symbol-dot.local',
            'password'  => '12345678'
        ]);

        $grabbedData = $this->grabDataFromResponseByJsonPath('access_token');
        if(!count($grabbedData))
        {
            throw new Exception('Bad credentials');
        }

        $accessToken = $grabbedData[0];
        $this->haveHttpHeader('Authorization', "bearer $accessToken");
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function createDummyContact()
    {
        $data = [
            'first_name' => 'Foo',
            'last_name'  => 'Bar'
        ];
        $this->sendPost('/api/v1/contacts', $data);
        return json_decode($this->grabResponse(), true);
    }
}
