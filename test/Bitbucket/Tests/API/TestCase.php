<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Api;
use Bitbucket\API\Http\HttpPluginClientBuilder;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var ?Client */
    protected $mockClient;
    /** @var Psr17Factory */
    private $psr17Factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->psr17Factory = new Psr17Factory();
    }

    /**
     * @template T of \Bitbucket\API\Api
     * @param class-string<T> $class
     * @return T
     */
    protected function getApiMock(string $class): Api
    {
        $bitbucketClient = new \Bitbucket\API\Http\Client(array(), $this->getHttpPluginClientBuilder());

        return new $class([], $bitbucketClient);
    }

    protected function getMockHttpClient(): Client
    {
        if (!isset($this->mockClient)) {
            $this->mockClient = new Client();
        }

        return $this->mockClient;
    }

    protected function getHttpPluginClientBuilder(): HttpPluginClientBuilder
    {
        return new HttpPluginClientBuilder($this->getMockHttpClient());
    }

    /**
     * @param array<mixed>|string $data
     */
    protected function fakeResponse($data, int $statusCode = 200): ResponseInterface
    {
        $response = $this->psr17Factory->createResponse($statusCode)
            ->withBody($this->psr17Factory->createStream(is_array($data) ? json_encode($data) : (string) $data));

        $this->getMockHttpClient()->addResponse($response);

        return $response;
    }

    protected function assertResponse(ResponseInterface $expected, ResponseInterface $actual): void
    {
        $this->assertSame($expected->getStatusCode(), $actual->getStatusCode());
        $expected->getBody()->rewind();
        $expectedContent = $expected->getBody()->getContents();
        $actual->getBody()->rewind();
        $actualContent = $actual->getBody()->getContents();
        $this->assertSame($expectedContent, $actualContent);
    }

    protected function assertRequest(string $method, string $endpoint, string $requestBody = '', string $query = ''): void
    {
        /** @var RequestInterface $request */
        $request = $this->mockClient->getLastRequest();
        $this->assertSame($endpoint, $request->getUri()->getPath());
        $this->assertSame($method, $request->getMethod());

        $request->getBody()->rewind();
        $this->assertSame($requestBody, $request->getBody()->getContents());
        $this->assertSame($query, $request->getUri()->getQuery());
    }

    /**
     * @param class-string $class
     */
    protected function getMethod(string $class, string $name): \ReflectionMethod
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
