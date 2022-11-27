<?php

namespace Bitbucket\Tests\API\Teams;

use Bitbucket\API\Teams\Permissions;
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

    public function testAll(): void
    {
        $endpoint = '/2.0/teams/gentle/permissions';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->permissions->all('gentle');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testRepositories(): void
    {
        $endpoint = '/2.0/teams/gentle/permissions/repositories';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->permissions->repositories('gentle');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testRepository(): void
    {
        $endpoint = '/2.0/teams/gentle/permissions/repositories/eof';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->permissions->repository('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }
}
