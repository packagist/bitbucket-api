<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Repositories;

class RepositoriesTest extends TestCase
{
    /** @var Repositories */
    private $repositories;

    protected function setUp()
    {
        parent::setUp();
        $this->repositories = $this->getApiMock(Repositories::class);
    }

    public function testGetAllRepositories()
    {
        $endpoint = '/2.0/repositories/gentle';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->repositories->all('gentle');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }
}
