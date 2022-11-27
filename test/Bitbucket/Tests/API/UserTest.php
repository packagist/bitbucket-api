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

    public function testGetEmails(): void
    {
        $endpoint = '/2.0/user/emails';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->user->emails();

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetUserProfileSuccess(): void
    {
        $endpoint = '/2.0/user/';
        $expectedResult = $this->fakeResponse([]);

        $actual = $this->user->get();

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testPermissions(): void
    {
        $this->assertInstanceOf(User\Permissions::class, $this->user->permissions());
    }
}
