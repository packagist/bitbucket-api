<?php

namespace Bitbucket\API\Http\Plugin;

use Http\Client\Common\Plugin\Journal;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HistoryPlugin implements Journal
{
    use HistoryVersionBridge;

    /** @var RequestInterface */
    private $lastRequest;
    /** @var ResponseInterface */
    private $lastResponse;

    /**
     * @return RequestInterface|null
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * @return ResponseInterface|null
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    public function addSuccess(RequestInterface $request, ResponseInterface $response): void
    {
        $this->lastRequest = $request;
        $this->lastResponse = $response;
    }
}
