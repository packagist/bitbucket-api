<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Api;
use Bitbucket\API\Http\HttpPluginClientBuilder;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var Client */
    protected $mockClient;

    protected function getApiMock($class = null)
    {
        $class = is_null($class) ? '\Bitbucket\API\Api' : $class;

        $bitbucketClient = new \Bitbucket\API\Http\Client(array(), $this->getHttpPluginClientBuilder());
        /** @var Api $apiClient */
        $apiClient = new $class([], $bitbucketClient);

        return $apiClient;
    }

    private function getMockHttpClient()
    {
        if (!isset($this->mockClient)) {
            $this->mockClient = new Client();
        }

        return $this->mockClient;
    }

    protected function getHttpPluginClientBuilder()
    {
        return new HttpPluginClientBuilder($this->getMockHttpClient());
    }

    protected function fakeResponse($data, $statusCode = 200, $encodeResponse = true)
    {
        $messageFactory = MessageFactoryDiscovery::find();

        $responseBody = $encodeResponse ? json_encode($data) : $data;
        $response = $messageFactory->createResponse($statusCode, null, [], $responseBody);
        $this->getMockHttpClient()->addResponse($response);

        return $response;
    }

    protected function assertResponse(ResponseInterface $expected, ResponseInterface $actual)
    {
        $this->assertSame($expected->getStatusCode(), $actual->getStatusCode());
        $expected->getBody()->rewind();
        $expectedContent = $expected->getBody()->getContents();
        $actual->getBody()->rewind();
        $actualContent = $actual->getBody()->getContents();
        $this->assertSame($expectedContent, $actualContent);
    }

    protected function assertRequest($method, $endpoint, $requestBody = '', $query = '')
    {
        /** @var RequestInterface $request */
        $request = $this->mockClient->getLastRequest();
        $this->assertSame($endpoint, $request->getUri()->getPath());
        $this->assertSame($method, $request->getMethod());

        $request->getBody()->rewind();
        $this->assertSame($requestBody, $request->getBody()->getContents());
        $this->assertSame($query, $request->getUri()->getQuery());
    }

    protected function getMethod($class, $name)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
