<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Workspaces;

class WorkspacesTest extends TestCase
{
    /** @var Workspaces */
    private $workspaces;

    protected function setUp(): void
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
}
