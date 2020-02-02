<?php

namespace Bitbucket\Tests\API\Http\Response;

use Bitbucket\API\Http\Response\Pager;
use Bitbucket\Tests\API\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class PagerTest extends TestCase
{
    public function testFetchNextSuccess()
    {
        $response = $this->fakeResponse([
            'values' => [],
            'next' => 'https://example.com/something?page=2'
        ]);

        $page = new Pager($this->getHttpPluginClientBuilder(), $response);

        $this->assertTrue($page->hasNext());
        $this->assertInstanceOf(ResponseInterface::class, $page->fetchNext());
    }

    public function testFetchNextFail()
    {
        $response = $this->fakeResponse([
            'values' => [],
        ]);

        $page = new Pager($this->getHttpPluginClientBuilder(), $response);

        $this->assertFalse($page->hasNext());
        $this->assertNull($page->fetchNext());
    }

    public function testFetchPreviousSuccess()
    {
        $response = $this->fakeResponse([
            'values' => [],
            'previous' => 'https://example.com/something?page=2'
        ]);

        $page = new Pager($this->getHttpPluginClientBuilder(), $response);

        $this->assertTrue($page->hasPrevious());
        $this->assertInstanceOf(ResponseInterface::class, $page->fetchPrevious());
    }

    public function testFetchPreviousFail()
    {
        $response = $this->fakeResponse([
            'values' => [],
        ]);

        $page = new Pager($this->getHttpPluginClientBuilder(), $response);

        $this->assertFalse($page->hasPrevious());
        $this->assertNull($page->fetchPrevious());
    }

    public function testFetchAllSuccess()
    {
        $response = $this->fakeResponse([
            'values' => ['dummy_1' => 'value_1'],
            'next' => 'https://example.com/something?page=2',
        ]);
        $this->fakeResponse([
            'values' => ['dummy_2' => 'value_2'],
            'next' => 'https://example.com/something?page=3',
        ]);
        $this->fakeResponse(['values' => ['dummy_3' => 'value_3']]);

        $expected = [
            'values' => [
                'dummy_1' => 'value_1',
                'dummy_2' => 'value_2',
                'dummy_3' => 'value_3'
            ]
        ];

        $page = new Pager($this->getHttpPluginClientBuilder(), $response);
        $response = $page->fetchAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals($expected, json_decode($response->getBody()->getContents(), true));
    }

    public function testFetchAllWithEmptyResponseShouldReturnEmptyValuesArray()
    {
        $response = $this->fakeResponse(['values' => []]);
        $this->fakeResponse(['values' => []]);
        $this->fakeResponse(['values' => []]);

        $page = new Pager($this->getHttpPluginClientBuilder(), $response);
        $response = $page->fetchAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(['values' => []], json_decode($response->getBody()->getContents(), true));
    }

    public function testFetchAllWithInvalidJsonShouldReturnEmptyValuesArray()
    {
        $expected = ['values' => []];
        $response = $this->fakeResponse('{"something": "yes"', 200, false);

        $page = new Pager($this->getHttpPluginClientBuilder(), $response);
        $response = $page->fetchAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals($expected, json_decode($response->getBody()->getContents(), true));
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testFetchAllWithUnauthorizedHeaderShouldFail()
    {
        $response = $this->fakeResponse([], 401);

        new Pager($this->getHttpPluginClientBuilder(), $response);
    }

    public function testGetCurrentResponseSuccess()
    {
        $response = $this->fakeResponse(json_encode([
            'values' => [],
            'previous' => 'https://example.com/something?page=2'
        ]));

        $page = new Pager($this->getHttpPluginClientBuilder(), $response);
        $response = $page->getCurrent();

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
