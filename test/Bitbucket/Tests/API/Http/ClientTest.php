<?php

namespace Bitbucket\Tests\API\Http;

use Bitbucket\Tests\API as Tests;
use Bitbucket\API\Http\Client;
use Http\Client\Common\HttpMethodsClient;
use Psr\Http\Message\ResponseInterface;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class ClientTest extends Tests\TestCase
{
    /** @var Client */
    private $client;

    public function setUp(): void
    {
        $this->client = new Client(array(), $this->getHttpPluginClientBuilder());
    }

    public function testGetSelfInstance(): void
    {
        $this->assertInstanceOf(HttpMethodsClient::class, $this->client->getClient());
    }

    /**
     * @dataProvider invalidApiVersionsProvider
     * @param int|string $version
     * @ticket 57
     */
    public function testSetApiVersionInvalid($version): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->client->setApiVersion($version);
    }

    public function testApiVersionSuccess(): void
    {
        $this->client->setApiVersion('2.0');
        $this->assertEquals('2.0', $this->client->getApiVersion());
        $this->client->setApiVersion('1.0');
        $this->assertEquals('1.0', $this->client->getApiVersion());
    }

    /**
     * @dataProvider apiBaseUrlProvider
     */
    public function testGetApiBaseUrl(string $apiVersion, string $expected): void
    {
        $this->client->setApiVersion($apiVersion);
        $this->assertEquals($expected, $this->client->getApiBaseUrl());
    }

    public function apiBaseUrlProvider(): array
    {
        return [
            ['1.0', 'https://api.bitbucket.org/1.0'],
            ['2.0', 'https://api.bitbucket.org/2.0'],
        ];
    }

    public function testShouldDoGetRequestAndReturnResponseInstance(): void
    {
        $endpoint = '/repositories/gentle/eof/issues/3';
        $params = ['format' => 'json'];
        $headers = ['2' => '4'];
        $baseClient = $this->getHttpPluginClientBuilder();
        $client = new Client(
            [
                'base_url'      => 'https://example.com',
                'api_version'   => '1.0'
            ],
            $baseClient
        );
        $response   = $client->get($endpoint, $params, $headers);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertInstanceOf(ResponseInterface::class, $client->getLastResponse());
    }

    public function testShouldDoPostRequestWithContentAndReturnResponseInstance(): void
    {
        $endpoint = '/repositories/gentle/eof/issues/3';
        $params = ['1' => '2'];
        $headers = ['3' => '4'];
        $baseClient = $this->getHttpPluginClientBuilder();
        $client = new Client(['user_agent' => 'tests'], $baseClient);
        $response   = $client->post($endpoint, $params, $headers);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(http_build_query($params), $client->getLastRequest()->getBody()->getContents());
        $this->assertEquals([
            'Content-Type' => ['application/x-www-form-urlencoded'],
            'User-Agent' => ['tests'],
            '3' => ['4'],
            'Host' => ['api.bitbucket.org'],
        ], $client->getLastRequest()->getHeaders());
    }

    /**
     * @ticket 74
     */
    public function testShouldDoPostRequestWithJsonContentAndReturnResponseInstance(): void
    {
        $endpoint = '/repositories/gentle/eof/pullrequests';
        $params = json_encode(['1' => '2', 'name' => 'john']);
        $headers = ['Content-Type' => 'application/json'];
        $baseClient = $this->getHttpPluginClientBuilder();
        $client = new Client(['user_agent' => 'tests'], $baseClient);
        $response   = $client->post($endpoint, $params, $headers);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals($params, $client->getLastRequest()->getBody()->getContents());
        $this->assertEquals([
            'Content-Type' => ['application/json'],
            'User-Agent' => ['tests'],
            'Host' => ['api.bitbucket.org'],
        ], $client->getLastRequest()->getHeaders());
    }

    public function testShouldDoPutRequestAndReturnResponseInstance(): void
    {
        $endpoint = '/repositories/gentle/eof/issues/3';
        $params = ['1' => '2'];
        $headers = ['3' => '4'];
        $baseClient = $this->getHttpPluginClientBuilder();
        $client = new Client([], $baseClient);
        $response = $client->put($endpoint, $params, $headers);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testShouldDoDeleteRequestAndReturnResponseInstance(): void
    {
        $endpoint = '/repositories/gentle/eof/issues/3';
        $params = ['1' => '2'];
        $headers = ['3' => '4'];
        $baseClient = $this->getHttpPluginClientBuilder();
        $client = new Client([], $baseClient);
        $response = $client->delete($endpoint, $params, $headers);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testShouldDoPatchRequestAndReturnResponseInstance(): void
    {
        $endpoint = '/repositories/gentle/eof/issues/3';
        $params = ['1' => '2'];
        $headers = ['3' => '4'];
        $baseClient = $this->getHttpPluginClientBuilder();
        $client = new Client([], $baseClient);
        $response = $client->request($endpoint, $params, 'PATCH', $headers);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testClientIsKeptWhenInvokingChildFactory(): void
    {
        $options = [
            'base_url' => 'https://localhost'
        ];
        $client = new Client($options);
        $pullRequest = new \Bitbucket\API\Repositories\PullRequests();
        $pullRequest->setClient($client);
        $comments = $pullRequest->comments();
        $this->assertSame($client, $comments->getClient());
    }

    /**
     * @dataProvider currentApiVersionProvider
     */
    public function testCurrentApiVersion(string $currentApiVersion, string $apiVersion, bool $expected): void
    {
        $this->client->setApiVersion($currentApiVersion);
        $this->assertSame($expected, $this->client->isApiVersion($apiVersion));
    }

    public function currentApiVersionProvider(): array
    {
        return [
            ['1.0', '1.0', true],
            ['2.0', '2.0', true],
            ['1.0', '2.0', false],
            ['2.0', '1', false],
            ['2.0', '2', true],
        ];
    }

    /**
     * @ticket 64
     */
    public function testIncludeFormatParamOnlyInV1(): void
    {
        $endpoint = sprintf(
            '/repositories/gentlero/bitbucket-api/src/%s/%s',
            'develop',
            'lib/Bitbucket/API/Repositories'
        );
        $params = $headers = [];

        $baseClient = $this->getHttpPluginClientBuilder();
        $client = new Client(['api_version' => '2.0'], $baseClient);
        $client->get($endpoint, $params, $headers);

        $req    = $client->getLastRequest()->getUri();
        $parts  = parse_url($req);

        if (false === array_key_exists('query', $parts)) {
            $parts['query'] = '';
        }

        $this->assertFalse(strpos($parts['query'], 'format'));
    }

    public function invalidApiVersionsProvider(): array
    {
        return [
            ['3.1'], ['1,2'], ['1,0'], ['2.1'], ['4'], [2], ['string'], [2.0]
        ];
    }
}
