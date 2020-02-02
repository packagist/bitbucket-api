<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Teams;

class TeamsTest extends TestCase
{
    /** @var Teams */
    private $teams;

    protected function setUp()
    {
        parent::setUp();
        $this->teams = $this->getApiMock(Teams::class);
    }

    public function invalidRoleProvider()
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
     * @expectedException \InvalidArgumentException
     */
    public function testGetTeamsListWithInvalidRole($role)
    {
        $this->teams->all($role);
    }

    public function testGetTeamsList()
    {
        $endpoint = '/2.0/teams';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->all('member');

        $this->assertRequest('GET', $endpoint, '', 'role=member');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetTeamProfile()
    {
        $endpoint = '/2.0/teams/gentle-web';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->profile('gentle-web');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetTeamMembers()
    {
        $endpoint = '/2.0/teams/gentle-web/members';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->members('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testGetTeamFollowers()
    {
        $endpoint = '/2.0/teams/gentle-web/followers';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->followers('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testGetTeamFollowing()
    {
        $endpoint = '/2.0/teams/gentle-web/following';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->following('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testGetTeamRepositories()
    {
        $endpoint = '/2.0/teams/gentle-web/repositories';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->teams->repositories('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testHooks()
    {
        $this->assertInstanceOf(Teams\Hooks::class, $this->teams->hooks());
    }

    public function testPermissions()
    {
        $this->assertInstanceOf(Teams\Permissions::class, $this->teams->permissions());
    }
}
