<?php

namespace Bitbucket\Tests\API\Workspaces;

use Bitbucket\API\Workspaces\Hooks;
use Bitbucket\API\Workspaces\Workspace;
use Bitbucket\Tests\API\TestCase;

class WorkspaceTest extends TestCase
{
    /** @var Workspace */
    private $workspace;

    protected function setUp(): void
    {
        parent::setUp();
        $this->workspace = $this->getApiMock(Workspace::class);
    }

    public function testGetWorkspace(): void
    {
        $endpoint = '/2.0/workspaces/gentle-web';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->workspace->workspace('gentle-web');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetWorkspaceMembers(): void
    {
        $endpoint = '/2.0/workspaces/gentle-web/members';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->workspace->members('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testGetWorkspaceProjects(): void
    {
        $endpoint = '/2.0/workspaces/gentle-web/projects';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->workspace->projects('gentle-web');

        $this->assertEquals($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint);
    }

    public function testHooks(): void
    {
        $this->assertInstanceOf(Hooks::class, $this->workspace->hooks());
    }
}
