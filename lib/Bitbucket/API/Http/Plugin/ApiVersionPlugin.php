<?php

namespace Bitbucket\API\Http\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ApiVersionPlugin implements Plugin
{
    use Plugin\VersionBridgePlugin;

    /** @var string */
    private $version;

    /**
     * @param string $version
     */
    public function __construct($version)
    {
        $this->version = $version;
    }

    /**
     * @param RequestInterface $request
     * @param callable $next Next middleware in the chain, the request is passed as the first argument
     * @param callable $first First middleware in the chain, used to to restart a request
     *
     * @return Promise<ResponseInterface> Resolves a PSR-7 Response or fails with an Http\Client\Exception (The same as HttpAsyncClient).
     */
    protected function doHandleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $uri = $request->getUri();
        if (strpos($uri->getPath(), '/' . $this->version) !== 0) {
            $request = $request->withUri($uri->withPath('/' . $this->version . $uri->getPath()));
        }

        return $next($request);
    }
}
