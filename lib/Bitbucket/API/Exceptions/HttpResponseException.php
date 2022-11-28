<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class HttpResponseException extends \Exception
{
    /** @var ResponseInterface */
    private $response;
    /** @var RequestInterface */
    private $request;

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param  RequestInterface $request
     * @return $this
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param  ResponseInterface $response
     * @return $this
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }
}
