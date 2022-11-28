<?php

namespace Bitbucket\API\Http;

use Bitbucket\API\Http\Plugin\ApiVersionPlugin;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;

class HttpPluginClientBuilder
{
    /** @var HttpClient */
    private $httpClient;
    /** @var HttpMethodsClient|null */
    private $pluginClient;
    /** @var MessageFactory */
    private $messageFactory;
    /** @var Plugin[] */
    private $plugins = [];

    public function __construct(HttpClient $httpClient = null, MessageFactory $messageFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
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
                $this->messageFactory
            );
        }

        return $this->pluginClient;
    }

    /**
     * @return MessageFactory
     */
    public function getMessageFactory()
    {
        return $this->messageFactory;
    }
}
