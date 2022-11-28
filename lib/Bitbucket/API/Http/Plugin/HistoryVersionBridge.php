<?php

namespace Bitbucket\API\Http\Plugin;

use Http\Client\Exception;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;

if (\interface_exists(\Http\Client\Common\HttpMethodsClientInterface::class)) {
    trait HistoryVersionBridge
    {
        // History method for php-http/client-common 2
        public function addFailure(RequestInterface $request, ClientExceptionInterface $exception): void
        {
        }
    }
} else {
    trait HistoryVersionBridge
    {
        // History method for php-http/client-common 1
        public function addFailure(RequestInterface $request, Exception $exception): void
        {
        }
    }
}
