<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Teams;

class TeamsTest extends TestCase
{
    /** @var Teams */
    private $teams;

    protected function setUp(): void
    {
        parent::setUp();
        $this->teams = $this->getApiMock(Teams::class);
    }

    public function invalidRoleProvider(): array
    {
        return [
            ['invalid'],
            [2],
            [['invalid']],
            ['2.0'],
            [true],
            [['admin']],
            [[]]
        ];
    }

    /**
     * @dataProvider invalidRoleProvider
     * @param int|string|bool|array $role
     */
    public function testGetTeamsListWithInvalidRole($role): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->teams->all($role);
    }

    public function testGetTeamsList(): void
    {
        $endpoint = '/2.0/teams';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->all('member');

        $this->assertRequest('GET', $endpoint, '', 'role=member');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetTeamProfile(): void
    {
        $endpoint = '/2.0/teams/gentle-web';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->profile('gentle-web');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetTeamMembers(): void
    {
        $endpoint = '/2.0/teams/gentle-web/members';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->members('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testGetTeamFollowers(): void
    {
        $endpoint = '/2.0/teams/gentle-web/followers';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->followers('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testGetTeamFollowing(): void
    {
        $endpoint = '/2.0/teams/gentle-web/following';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->following('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testGetTeamRepositories(): void
    {
        $endpoint = '/2.0/teams/gentle-web/repositories';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->repositories('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testHooks(): void
    {
        $this->assertInstanceOf(Teams\Hooks::class, $this->teams->hooks());
    }

    public function testPermissions(): void
    {
        $this->assertInstanceOf(Teams\Permissions::class, $this->teams->permissions());
    }
}
