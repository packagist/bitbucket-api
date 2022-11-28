<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\Refs;
use Bitbucket\Tests\API\TestCase;

class RefsTest extends TestCase
{
    /** @var Refs */
    private $refs;

    protected function setUp(): void
    {
        parent::setUp();
        $this->refs = $this->getApiMock(Refs::class);
    }

    public function testAll(): void
    {
        $endpoint= '/2.0/repositories/gentle/eof/refs';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->refs->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testAllParams(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/refs';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->refs->all('gentle', 'eof', ['pagelen' => 36]);

        $this->assertRequest('GET', $endpoint, '', 'pagelen=36');
        $this->assertResponse($expectedResult, $actual);
    }
}
