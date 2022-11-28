<?php

namespace Bitbucket\Tests\API\Http\Plugin;

use Bitbucket\Tests\API as Tests;
use Bitbucket\API\Http\Plugin\ApiOneCollectionPlugin;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Promise\HttpFulfilledPromise;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class ApiOneCollectionPluginTest extends Tests\TestCase
{
    public function testMetadataExistsForApiV1(): void
    {
        $content = [
            'count' => 5,
            'issues' => [
                'issue_3' => [],
                'issue_4' => []
            ]
        ];

        $plugin = new ApiOneCollectionPlugin();
        $request = new Request('GET', 'http://localhost/1.0/repositories/team/repo/issues?limit=2&start=2');
        $response = new Response(200, [], json_encode($content));

        $next = function () use ($response) {
            return new HttpFulfilledPromise($response);
        };
        $result = $plugin->handleRequest($request, $next, function () {
            throw new \RuntimeException('Not expected to call first callable');
        })->wait(true);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $body = json_decode($result->getBody()->getContents(), true);

        $this->assertEquals($content['issues'], $body['issues']);

        $this->assertArrayHasKey('values', $body);
        $this->assertEquals($body['values'], '.issues');

        $this->assertArrayHasKey('next', $body);
        $this->assertEquals('http://localhost/1.0/repositories/team/repo/issues?limit=2&start=4', $body['next']);
        $this->assertArrayHasKey('previous', $body);
        $this->assertEquals('http://localhost/1.0/repositories/team/repo/issues?limit=2&start=0', $body['previous']);
    }

    public function testNonExistentPageReturnsLastPage(): void
    {
        $content = [
            'count' => 5,
            'issues' => [
                'issue_5' => []
            ]
        ];

        $plugin = new ApiOneCollectionPlugin();
        $request = new Request('GET', 'http://localhost/1.0/repositories/team/repo/issues?limit=2&start=6');
        $response = new Response(200, [], json_encode($content));

        $next = function () use ($response) {
            return new HttpFulfilledPromise($response);
        };
        $result = $plugin->handleRequest($request, $next, function () {
            throw new \RuntimeException('Not expected to call first callable');
        })->wait(true);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $body = json_decode($result->getBody()->getContents(), true);

        $this->assertEquals($content['issues'], $body['issues']);

        $this->assertArrayHasKey('values', $body);
        $this->assertEquals($body['values'], '.issues');

        $this->assertArrayNotHasKey('next', $body);
        $this->assertArrayHasKey('previous', $body);
        $this->assertEquals('http://localhost/1.0/repositories/team/repo/issues?limit=2&start=4', $body['previous']);
    }

    public function testInvalidJsonResponseShouldResultInANullBodyContent(): void
    {
        $plugin = new ApiOneCollectionPlugin();
        $request = new Request('GET', 'http://localhost/1.0/repositories/team/repo/issues?limit=2&start=2');
        $response = new Response(200, [], '{"key": "value}');

        $next = function () use ($response) {
            return new HttpFulfilledPromise($response);
        };
        $result = $plugin->handleRequest($request, $next, function () {
            throw new \RuntimeException('Not expected to call first callable');
        })->wait(true);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $body = json_decode($response->getBody()->getContents(), true);
        $this->assertNull($body);
    }

    public function testResponseWithoutCollection(): void
    {
        $content = [
            'issues' => [
                'issue_3' => [],
                'issue_4' => []
            ]
        ];

        $plugin = new ApiOneCollectionPlugin();
        $request = new Request('GET', 'http://localhost/1.0/repositories/team/repo/issues');
        $response = new Response(200, [], json_encode($content));

        $next = function () use ($response) {
            return new HttpFulfilledPromise($response);
        };
        $result = $plugin->handleRequest($request, $next, function () {
            throw new \RuntimeException('Not expected to call first callable');
        })->wait(true);

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $body = json_decode($result->getBody()->getContents(), true);

        $this->assertEquals($content['issues'], $body['issues']);

        $this->assertArrayNotHasKey('values', $body);
        $this->assertArrayNotHasKey('count', $body);
        $this->assertArrayNotHasKey('next', $body);
        $this->assertArrayNotHasKey('previous', $body);
    }
}
