<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Api;
use Http\Message\Authentication\BasicAuth;

class ApiTest extends TestCase
{
    public function testCredentials(): void
    {
        $api = new Api;
        $api->setCredentials(new BasicAuth('api_username', 'api_password'));
    }

    public function testShouldDoGetRequest(): void
    {
        $endpoint = '/repositories/gentle/eof/issues/3';
        $params = [];
        $headers = [];
        $api = $this->getApiMock(Api::class);

        $api->requestGet($endpoint, $params, $headers);

        $request = $this->mockClient->getLastRequest();

        $this->assertSame('/' . $api->getClient()->getApiVersion() . $endpoint, $request->getUri()->getPath());
        $this->assertSame('GET', $request->getMethod());
    }

    public function testShouldDoPostRequest(): void
    {
        $endpoint = '/repositories/gentle/eof/issues/3';
        $params = ['key' => 'value'];
        $headers = [];
        $api = $this->getApiMock(Api::class);

        $api->requestPost($endpoint, $params, $headers);

        $request = $this->mockClient->getLastRequest();

        $this->assertSame('/' . $api->getClient()->getApiVersion() . $endpoint, $request->getUri()->getPath());
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame(http_build_query($params), $request->getBody()->getContents());
    }

    public function testShouldDoPutRequest(): void
    {
        $endpoint = '/repositories/gentle/eof/issues/3';
        $params = ['key' => 'value'];
        $headers = [];
        $api = $this->getApiMock(Api::class);

        $api->requestPut($endpoint, $params, $headers);

        $request = $this->mockClient->getLastRequest();

        $this->assertSame('/' . $api->getClient()->getApiVersion() . $endpoint, $request->getUri()->getPath());
        $this->assertSame('PUT', $request->getMethod());
        $this->assertSame(http_build_query($params), $request->getBody()->getContents());
    }

    public function testShouldDoDeleteRequest(): void
    {
        $endpoint = '/repositories/gentle/eof/issues/3';
        $params = [];
        $headers = [];

        $api = $this->getApiMock(Api::class);

        $api->requestDelete($endpoint, $params, $headers);

        $request = $this->mockClient->getLastRequest();

        $this->assertSame('/' . $api->getClient()->getApiVersion() . $endpoint, $request->getUri()->getPath());
        $this->assertSame('DELETE', $request->getMethod());
    }
}
