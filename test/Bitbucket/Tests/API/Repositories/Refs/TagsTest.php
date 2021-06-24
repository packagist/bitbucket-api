<?php

namespace Bitbucket\Tests\API\Repositories\Refs;

use Bitbucket\API\Repositories\Refs\Tags;
use Bitbucket\Tests\API\TestCase;

class TagsTest extends TestCase
{
    /** @var Tags */
    private $tags;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tags = $this->getApiMock(Tags::class);
    }

    public function testAll()
    {
        $endpoint = '/2.0/repositories/gentle/eof/refs/tags';
        $expectedResult = $this->fakeResponse('dummy');

        $actual = $this->tags->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testAllParams()
    {
        $params = ['pagelen'=>36];
        $endpoint = '/2.0/repositories/gentle/eof/refs/tags';
        $expectedResult = $this->fakeResponse('dummy');

        $actual = $this->tags->all('gentle', 'eof', $params);

        $this->assertRequest('GET', $endpoint, '', 'pagelen=36');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGet()
    {
        $endpoint = '/2.0/repositories/gentle/eof/refs/tags/atag';
        $expectedResult = $this->fakeResponse('dummy');

        $actual = $this->tags->get('gentle', 'eof', 'atag');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreate()
    {
        $endpoint = '/2.0/repositories/gentle/eof/refs/tags';
        $expectedResult = $this->fakeResponse('dummy');

        $actual = $this->tags->create('gentle', 'eof', 'atag', '2310abb944423ecf1a90be9888dafd096744b531');

        $expectedBody = ['name' => 'atag', 'target' => ['hash' => '2310abb944423ecf1a90be9888dafd096744b531']];
        $this->assertRequest('POST', $endpoint, json_encode($expectedBody));
        $this->assertResponse($expectedResult, $actual);
    }
}
