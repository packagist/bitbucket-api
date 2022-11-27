<?php

namespace Bitbucket\Tests\API\Repositories\Refs;

use Bitbucket\API\Repositories\Refs\Branches;
use Bitbucket\Tests\API\TestCase;

class BranchesTest extends TestCase
{
    /** @var Branches */
    private $branches;

    protected function setUp(): void
    {
        parent::setUp();
        $this->branches = $this->getApiMock(Branches::class);
    }

    public function testAll(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/refs/branches';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->branches->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testAllParams(): void
    {
        $params = ['pagelen' => 36];
        $endpoint = '/2.0/repositories/gentle/eof/refs/branches';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->branches->all('gentle', 'eof', $params);

        $this->assertRequest('GET', $endpoint, '', 'pagelen=36');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGet(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/refs/branches/abranch';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->branches->get('gentle', 'eof', 'abranch');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testDelete(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/refs/branches/abranch';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->branches->delete('gentle', 'eof', 'abranch');

        $this->assertRequest('DELETE', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }
}
