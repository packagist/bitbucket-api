<?php
/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitbucket\API\Http\Plugin;

use Http\Client\Common\Plugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Helper for `Pager`
 *
 * Inserts pagination metadata (_as is expected by `Pager`_),
 * in any response coming from v1 of the API which contains
 * a collection.
 *
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class ApiOneCollectionPlugin implements Plugin
{
    use Plugin\VersionBridgePlugin;

    /** @var StreamFactoryInterface */
    private $streamFactory;

    /** @var array */
    private $urlQueryComponents;

    /** @var string */
    private $resource;

    /** @var array */
    private $content;

    /**
     * @param object|null $responseFactory This argument is deprecated and will be removed in 3.0
     */
    public function __construct($responseFactory = null)
    {
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        unset($responseFactory);
    }

    /**
     * @return callable
     */
    protected function doHandleRequest(RequestInterface $request, callable $next, callable $first)
    {
        return $next($request)->then(function (ResponseInterface $response) use ($request) {
            if ($this->isLegacyApiVersion($request)) {
                $this->parseRequest($request);

                if ($this->canPaginate($response)) {
                    $content = $this->insertPaginationMeta(
                        $this->getContent($response),
                        $this->getPaginationMeta($response),
                        $request
                    );

                    return $response
                        ->withBody($this->streamFactory->createStream(json_encode($content)));
                }
            }

            return $response;
        });
    }

    /**
     * @param  RequestInterface $request
     * @return bool
     */
    private function isLegacyApiVersion(RequestInterface $request)
    {
        /** @var RequestInterface $request */
        return strpos($request->getUri()->getPath(), '/1.0/') !== false;
    }

    /**
     * @param  RequestInterface $request
     * @return void
     */
    private function parseRequest(RequestInterface $request)
    {
        if ($request->getUri()->getQuery()) {
            parse_str($request->getUri()->getQuery(), $this->urlQueryComponents);
        } else {
            $this->urlQueryComponents = [];
        }

        $this->urlQueryComponents['start'] = array_key_exists('start', $this->urlQueryComponents) ?
            (int)$this->urlQueryComponents['start'] :
            0
        ;
        $this->urlQueryComponents['limit'] = array_key_exists('limit', $this->urlQueryComponents) ?
            (int)$this->urlQueryComponents['limit'] :
            15
        ;

        $pcs = explode('/', $request->getUri()->getPath());
        $this->resource = strtolower(array_pop($pcs));
    }

    /**
     * @param  ResponseInterface $response
     * @return bool
     */
    private function canPaginate(ResponseInterface $response)
    {
        $content = $this->getContent($response);

        return array_key_exists('count', $content) && array_key_exists($this->resource, $content);
    }

    /**
     * @param  ResponseInterface $response
     * @return array
     */
    private function getContent(ResponseInterface $response)
    {
        if (null === $this->content) {
            $content = json_decode($response->getBody()->getContents(), true);
            $response->getBody()->rewind();

            if (is_array($content) && JSON_ERROR_NONE === json_last_error()) {
                $this->content = $content;
            } else {
                $this->content = [];
            }
        }

        return $this->content;
    }

    /**
     * @param  array $content
     * @param  array $pagination
     * @return array
     */
    private function insertPaginationMeta(array $content, array $pagination, RequestInterface $request)
    {
        // This is just a reference because duplicate data in response could create confusion between some users.
        $content['values']  = '.'.$this->resource;
        $content['size']    = $content['count'];

        // insert pagination links only if everything does not fit in a single page
        if ($content['count'] > count($content[$this->resource])) {
            if ($pagination['page'] > 1 || $pagination['page'] === $pagination['pages']) {
                $query = $this->urlQueryComponents;
                $query['start'] -= $this->urlQueryComponents['limit'];

                $content['previous'] = sprintf(
                    '%s://%s%s?%s',
                    $request->getUri()->getScheme(),
                    $request->getUri()->getHost(),
                    $request->getUri()->getPath(),
                    http_build_query($query)
                );
            }

            if ($pagination['page'] < $pagination['pages']) {
                $query = $this->urlQueryComponents;
                $query['start'] += $this->urlQueryComponents['limit'];

                $content['next'] = sprintf(
                    '%s://%s%s?%s',
                    $request->getUri()->getScheme(),
                    $request->getUri()->getHost(),
                    $request->getUri()->getPath(),
                    http_build_query($query)
                );
            }
        }

        return $content;
    }

    /**
     * @param  ResponseInterface $response
     * @return array
     */
    private function getPaginationMeta(ResponseInterface $response)
    {
        $meta = [];

        $content        = $this->getContent($response);
        $meta['total']  = $content['count'];
        $meta['pages']  = (int)ceil($meta['total'] / $this->urlQueryComponents['limit']);
        $meta['page']   = ($this->urlQueryComponents['start']/$this->urlQueryComponents['limit']) === 0 ?
            1 :
            ($this->urlQueryComponents['start']/$this->urlQueryComponents['limit'])+1
        ;

        if ($meta['page'] > $meta['pages']) {
            $meta['page'] = $meta['pages'];
        }

        return $meta;
    }
}
