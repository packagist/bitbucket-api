<?php

namespace Bitbucket\Tests\API\Http\Plugin;

use Bitbucket\API\Http\Plugin\OAuthPlugin;
use Bitbucket\Tests\API as Tests;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Promise\HttpFulfilledPromise;
use JacobKiers\OAuth\SignatureMethod\HmacSha1;
use JacobKiers\OAuth\Token\NullToken;
use JacobKiers\OAuth\Token\Token;
use Psr\Http\Message\RequestInterface;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class OAuthPluginTest extends Tests\TestCase
{
    public function testInvalidSignatureShouldFallbackToHmacSha1()
    {
        $oauth = new OAuthPlugin(['oauth_signature_method' => 'dummy']);
        $reflection = new \ReflectionClass($oauth);
        $property = $reflection->getProperty('signature');

        $property->setAccessible(true);

        $this->assertInstanceOf(HmacSha1::class, $property->getValue($oauth));
    }

    public function testTokenInstantiateForOneLegged()
    {
        $oauth = new OAuthPlugin([
            'oauth_consumer_key' => 'aaa',
            'oauth_consumer_secret' => 'bbb'
        ]);

        $reflection = new \ReflectionClass($oauth);
        $property = $reflection->getProperty('token');

        $property->setAccessible(true);

        $this->assertInstanceOf(NullToken::class, $property->getValue($oauth));
    }

    public function testTokenInstantiateForThreeLegged()
    {
        $oauth = new OAuthPlugin([
            'oauth_consumer_key' => 'aaa',
            'oauth_consumer_secret' => 'bbb',
            'oauth_token' => 'ccc',
            'oauth_token_secret' => 'ddd'
        ]);

        $reflection = new \ReflectionClass($oauth);
        $property = $reflection->getProperty('token');

        $property->setAccessible(true);

        $this->assertInstanceOf(Token::class, $property->getValue($oauth));
    }

    public function testFilterOAuthParameters()
    {
        $method = $this->getMethod(OAuthPlugin::class, 'filterOAuthParameters');
        $actual = $method->invokeArgs(new OAuthPlugin([]), [['invalid_option', 'oauth_version']]);

        $this->assertArrayHasKey('oauth_version', $actual);
        $this->assertArrayNotHasKey('invalid_option', $actual);
    }

    public function testMakeSureRequestIncludesOAuthHeader()
    {
        $oauth_params = [
            'oauth_consumer_key' => 'aaa',
            'oauth_consumer_secret' => 'bbb'
        ];

        $request = new Request(
            'GET',
            OAuthPlugin::ENDPOINT_REQUEST_TOKEN,
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
        $listener = new OAuthPlugin($oauth_params);
        $listener->handleRequest($request, function (RequestInterface $request) use ($oauth_params) {
            $authHeader = $request->getHeader('Authorization')[0];
            $this->assertContains('OAuth', $authHeader);
            $this->assertContains(
                sprintf('oauth_consumer_key="%s"', $oauth_params['oauth_consumer_key']),
                $authHeader
            );

            return new HttpFulfilledPromise(new Response());
        }, function () {
        });
    }
}
