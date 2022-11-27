<?php

namespace Bitbucket\Tests\API\Http\Plugin;

use Bitbucket\API\Http\Plugin\NormalizeArrayPlugin;
use Bitbucket\Tests\API as Tests;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\Promise\HttpFulfilledPromise;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class NormalizeArrayPluginTest extends Tests\TestCase
{
    public function testPHPArrayToApiArrayConversionForQuery(): void
    {
        $plugin = new NormalizeArrayPlugin();
        $query = http_build_query(['state' => ['OPEN', 'MERGED']]);
        $request = new Request('GET', '/repositories/acme/repo/pullrequests?' . $query);

        $next = function ($request) {
            $this->assertEquals(
                '/repositories/acme/repo/pullrequests?state=OPEN&state=MERGED',
                (string) $request->getUri()
            );

            return new HttpFulfilledPromise(new Response());
        };
        $plugin->handleRequest($request, $next, function () {
            throw new \RuntimeException('Not expected to call first callable');
        });
    }
}
