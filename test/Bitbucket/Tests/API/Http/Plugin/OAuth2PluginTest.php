<?php

namespace Bitbucket\Tests\API\Http\Plugin;

use Bitbucket\API\Http\ClientInterface;
use Bitbucket\Tests\API as Tests;
use Bitbucket\API\Http\Plugin\OAuth2Plugin;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Promise\HttpFulfilledPromise;
use Psr\Http\Message\RequestInterface;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class OAuth2PluginTest extends Tests\TestCase
{
    /**
     * @expectedException \Bitbucket\API\Exceptions\ForbiddenAccessException
     */
    public function testGetAccessTokenShouldFailWithInvalidJson()
    {
        $oauth_params = [
            'client_id' => 'aaa',
            'client_secret' => 'bbb'
        ];

        $response = new Response(200, [], '{"bla": "boo}');

        $httpClient = $this->getMockBuilder(ClientInterface::class)->getMock();

        $httpClient
            ->expects($this->once())
            ->method('getLastRequest')
            ->willReturn($this->getMockBuilder(RequestInterface::class)->getMock());

        $httpClient
            ->expects($this->once())
            ->method('post')
            ->with($this->equalTo(OAuth2Plugin::ENDPOINT_ACCESS_TOKEN), [
                'grant_type'    => 'client_credentials',
                'client_id'     => $oauth_params['client_id'],
                'client_secret' => $oauth_params['client_secret'],
                'scope'         => ''
            ])
            ->willReturn($response)
        ;

        $request = new Request('GET', '/');
        $plugin = new OAuth2Plugin($oauth_params, $httpClient);
        $plugin->handleRequest($request, function () {
        }, function () {
        });
    }

    /**
     * @expectedException \Bitbucket\API\Exceptions\ForbiddenAccessException
     */
    public function testGetAccessTokenFail()
    {
        $responseBody = '{"error_description": "Invalid OAuth client credentials", "error": "unauthorized_client"}';
        $response = new Response(200, [], $responseBody);

        $oauth_params = [
            'client_id' => 'aaa',
            'client_secret' => 'bbb'
        ];

        $httpClient = $this->getMockBuilder(ClientInterface::class)->getMock();
        $httpClient
            ->expects($this->once())
            ->method('POST')
            ->with($this->equalTo(OAuth2Plugin::ENDPOINT_ACCESS_TOKEN), $this->equalTo([
                'grant_type' => 'client_credentials',
                'client_id' => $oauth_params['client_id'],
                'client_secret' => $oauth_params['client_secret'],
                'scope' => ''
            ]))
            ->willReturn($response)
        ;

        $request = new Request('GET', '/');
        $plugin = new OAuth2Plugin($oauth_params, $httpClient);
        $plugin->handleRequest($request, function () {
        }, function () {
        });
    }

    public function testOauth2ListenerDoesNotReplaceExistingBearer()
    {
        $oauth_params = [
            'client_id' => 'aaa',
            'client_secret' => 'bbb'
        ];

        $httpClient = $this->getMockBuilder(ClientInterface::class)->getMock();
        $httpClient
            ->expects($this->never())
            ->method('post');

        $request = new Request('GET', '/', [
            'Authorization' => 'Bearer secret'
        ]);
        $plugin = new OAuth2Plugin($oauth_params, $httpClient);
        $plugin->handleRequest($request, function (RequestInterface $request) {
            $authHeader = $request->getHeader('Authorization')[0];

            $this->assertContains('Bearer', $authHeader);
            $this->assertContains('secret', $authHeader);

            return new HttpFulfilledPromise(new Response());
        }, function () {
        });
    }

    public function testMakeSureRequestIncludesBearer()
    {
        $oauth_params = [
            'client_id' => 'aaa',
            'client_secret' => 'bbb'
        ];

        $response = new Response(200, [], json_encode(array(
            'token_type' => 'Bearer',
            'access_token' => 'secret'
        )));

        $httpClient = $this->getMockBuilder(ClientInterface::class)->getMock();
        $httpClient
            ->expects($this->once())
            ->method('post')
            ->with($this->equalTo(OAuth2Plugin::ENDPOINT_ACCESS_TOKEN), $this->equalTo([
                'grant_type' => 'client_credentials',
                'client_id' => $oauth_params['client_id'],
                'client_secret' => $oauth_params['client_secret'],
                'scope' => ''
            ]))
            ->willReturn($response)
        ;

        $request = new Request('GET', '/');
        $plugin = new OAuth2Plugin($oauth_params, $httpClient);
        $plugin->handleRequest($request, function (RequestInterface $request) {
            $authHeader = $request->getHeader('Authorization')[0];

            $this->assertContains('Bearer', $authHeader);
            $this->assertContains('secret', $authHeader);

            return new HttpFulfilledPromise(new Response());
        }, function () {
        });
    }
}
