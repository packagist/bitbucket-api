<?php

namespace Bitbucket\API\Http;

use Bitbucket\API\Http\Plugin\ApiVersionPlugin;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\MessageFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class HttpPluginClientBuilder
{
    /** @var ClientInterface */
    private $httpClient;
    /** @var HttpMethodsClient|null */
    private $pluginClient;
    /** @var MessageFactory|RequestFactoryInterface */
    private $requestFactory;
    /** @var StreamFactoryInterface */
    private $streamFactory;
    /** @var Plugin[] */
    private $plugins = [];

    /**
     * @param MessageFactory|RequestFactoryInterface|null $requestFactory
     */
    public function __construct(ClientInterface $httpClient = null, $requestFactory = null, StreamFactoryInterface $streamFactory = null)
    {
        $requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        if ($requestFactory instanceof MessageFactory) {
            // Use same format as symfony/deprecation-contracts.
            @trigger_error(sprintf(
                'Since %s %s: %s is deprecated, use %s instead.',
                'private-packagist/bitbucket-api',
                '2.2.0',
                '\Http\Message\MessageFactory',
                RequestFactoryInterface::class
            ), \E_USER_DEPRECATED);
        } elseif (!$requestFactory instanceof RequestFactoryInterface) {
            /** @var mixed $requestFactory value unknown; set to mixed, prevent PHPStan complaining about guard clauses */
            throw new \TypeError(sprintf(
                '%s::__construct(): Argument #2 ($requestFactory) must be of type %s|%s, %s given',
                self::class,
                '\Http\Message\MessageFactory',
                RequestFactoryInterface::class,
                is_object($requestFactory) ? get_class($requestFactory) : gettype($requestFactory)
            ));
        }

        $this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    /**
     * @return void
     */
    public function addPlugin(Plugin $plugin)
    {
        if ($plugin instanceof ApiVersionPlugin) {
            array_unshift($this->plugins, $plugin);
        } else {
            $this->plugins[] = $plugin;
        }

        $this->pluginClient = null;
    }

    /**
     * @param class-string<Plugin> $pluginClass
     * @return void
     */
    public function removePlugin($pluginClass)
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $pluginClass) {
                unset($this->plugins[$idx]);
                $this->pluginClient = null;
            }
        }
    }

    /**
     * @param string $pluginClass
     * @return bool
     */
    public function hasPlugin($pluginClass)
    {
        foreach ($this->plugins as $idx => $plugin) {
            if ($plugin instanceof $pluginClass) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return HttpMethodsClient
     */
    public function getHttpClient()
    {
        if (!$this->pluginClient) {
            $this->pluginClient = new HttpMethodsClient(
                new PluginClient($this->httpClient, $this->plugins),
                $this->requestFactory,
                $this->streamFactory
            );
        }

        return $this->pluginClient;
    }

    /**
     * @return MessageFactory
     * @deprecated Use getRequestFactory instead. message will be removed with 3.0
     */
    public function getMessageFactory()
    {
        return $this->requestFactory instanceof MessageFactory
            ? $this->requestFactory
            : MessageFactoryDiscovery::find();
    }

    /**
     * @return RequestFactoryInterface
     */
    public function getRequestFactory()
    {
        return $this->requestFactory;
    }
}
