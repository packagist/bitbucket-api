<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\User;

class UserTest extends TestCase
{
    /** @var User */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->getApiMock(User::class);
    }

    public function testGetEmails()
    {
        $endpoint = '/2.0/user/emails';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->user->emails();

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetUserProfileSuccess()
    {
        $endpoint = '/2.0/user/';
        $expectedResult = $this->fakeResponse(json_encode('dumy'));

        $actual = $this->user->get();

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testPermissions()
    {
        $this->assertInstanceOf(User\Permissions::class, $this->user->permissions());
    }
}
