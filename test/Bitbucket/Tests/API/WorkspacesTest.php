<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Workspaces;

class WorkspacesTest extends TestCase
{
    /** @var Workspaces */
    private $workspaces;

    protected function setUp()
    {
        parent::setUp();
        $this->workspaces = $this->getApiMock(Workspaces::class);
    }

    public function testGetWorkspacesList()
    {
        $endpoint = '/2.0/workspaces';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->workspaces->all();

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetWorkspaceProfile()
    {
        $endpoint = '/2.0/workspaces/gentle-web';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->workspaces->profile('gentle-web');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetWorkspaceMembers()
    {
        $endpoint = '/2.0/workspaces/gentle-web/members';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->workspaces->members('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testGetWorkspaceProjects()
    {
        $endpoint = '/2.0/workspaces/gentle-web/projects';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->workspaces->projects('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testHooks()
    {
        $this->assertInstanceOf(Workspaces\Hooks::class, $this->workspaces->hooks());
    }
}
