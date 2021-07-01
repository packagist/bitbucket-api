<?php

namespace Bitbucket\Tests\API\User;

use Bitbucket\API\User\Permissions;
use Bitbucket\Tests\API\TestCase;

class PermissionsTest extends TestCase
{
    /** @var Permissions */
    private $permissions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->permissions = $this->getApiMock(Permissions::class);
    }

    public function testTeams()
    {
        $endpoint = '/2.0/user/permissions/teams';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->permissions->teams();

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testRepositories()
    {
        $endpoint = '/2.0/user/permissions/repositories';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->permissions->repositories();

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }
}
