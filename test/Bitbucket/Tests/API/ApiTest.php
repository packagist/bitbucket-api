<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Api;
use Http\Message\Authentication\BasicAuth;

class ApiTest extends TestCase
{
    public function testCredentials()
    {
        $api = new Api;
        $api->setCredentials(new BasicAuth('api_username', 'api_password'));
    }

    public function testShouldDoGetRequest()
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

    public function testShouldDoPostRequest()
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

    public function testShouldDoPutRequest()
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

    public function testShouldDoDeleteRequest()
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

    public function testFormat()
    {
        $this->expectException(\InvalidArgumentException::class);

        $api = new Api;

        // default format
        $this->assertEquals('json', $api->getFormat());

        // set new format
        $api->setFormat('xml');
        $this->assertEquals('xml', $api->getFormat());

        // invalid format
        $api->setFormat('invalid format');
    }

    /**
     * @dataProvider invalidChildNameProvider
     */
    public function testSPFShouldFailWithInvalidClassName($name)
    {
        $this->expectException(\InvalidArgumentException::class);

        $bitbucket = new Api();
        $bitbucket->api($name);
    }

    public function testDifferentHttpClientInstanceOnCloning()
    {
        $repo1 = new \Bitbucket\API\Repositories();
        $repo2 = clone $repo1;
        $repo1->setFormat('xml');

        $this->assertEquals('xml', $repo1->getFormat());
        $this->assertNotEquals('xml', $repo2->getFormat());
        $this->assertNotSame($repo1, $repo2);
    }

    public function invalidChildNameProvider()
    {
        return [
            [[]], [new \stdClass()], [21], ['32.4'], ['invalid']
        ];
    }
}
