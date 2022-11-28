<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitbucket\API\Http;

use Bitbucket\API\Http\Plugin\ApiVersionPlugin;
use Bitbucket\API\Http\Plugin\HistoryPlugin;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\MessageFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 * @phpstan-type ClientOption array{base_url: string, api_version: string, api_versions: string[], format: string, formats: string[], user_agent: string, timeout: int, verify_peer: bool}
 * @phpstan-type OptionalClientOption array{base_url?: string, api_version?: string, api_versions?: string[], format?: string, formats?: string[], user_agent?: string, timeout?: int, verify_peer?: bool}
 */
class Client implements ClientInterface
{
    /** @var ClientOption */
    protected $options = array(
        'base_url'      => 'https://api.bitbucket.org',
        'api_version'   => '2.0',
        'api_versions'  => array('1.0', '2.0'),     // supported versions
        'format'        => 'json',
        'formats'       => array('json', 'xml'),    // supported response formats
        'user_agent'    => 'bitbucket-api-php/2.0.0 (https://bitbucket.org/gentlero/bitbucket-api)',
        'timeout'       => 10,
        'verify_peer'   => true
    );

    /** @var HttpPluginClientBuilder */
    private $httpClientBuilder;
    /** @var MessageFactory */
    private $messageFactory;
    /** @var HistoryPlugin */
    private $responseHistory;

    /**
     * @param OptionalClientOption $options
     */
    public function __construct(array $options = array(), HttpPluginClientBuilder $httpClientBuilder = null)
    {
        $this->responseHistory = new HistoryPlugin();
        $this->options = array_merge(array_merge($this->options, $options));
        $this->httpClientBuilder = $httpClientBuilder ?: new HttpPluginClientBuilder();

        $this->httpClientBuilder->addPlugin(
            new Plugin\AddHostPlugin(UriFactoryDiscovery::find()->createUri($this->options['base_url']))
        );
        $this->httpClientBuilder->addPlugin(new Plugin\RedirectPlugin());
        $this->httpClientBuilder->addPlugin(new Plugin\HeaderDefaultsPlugin([
            'User-Agent' => $this->options['user_agent'],
        ]));
        $this->httpClientBuilder->addPlugin(new Plugin\HistoryPlugin($this->responseHistory));

        $this->setApiVersion($this->options['api_version']);

        $this->messageFactory = $this->httpClientBuilder->getMessageFactory();
    }

    /**
     * {@inheritdoc}
     */
    public function get($endpoint, $params = array(), $headers = array())
    {
        if (is_array($params) && count($params) > 0) {
            $endpoint   .= (strpos($endpoint, '?') === false ? '?' : '&').http_build_query($params, '', '&');
            $params     = array();
        }

        return $this->request($endpoint, $params, 'GET', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function post($endpoint, $params = array(), $headers = array())
    {
        return $this->request($endpoint, $params, 'POST', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function put($endpoint, $params = array(), $headers = array())
    {
        return $this->request($endpoint, $params, 'PUT', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($endpoint, $params = array(), $headers = array())
    {
        return $this->request($endpoint, $params, 'DELETE', $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function request($endpoint, $params = array(), $method = 'GET', array $headers = array())
    {
        // add a default content-type if none was set
        if (empty($headers['Content-Type']) && in_array(strtoupper($method), array('POST', 'PUT'), true)) {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        $paramsString = null;
        if (is_array($params) && count($params) > 0) {
            if (isset($headers['Content-Type']) && $headers['Content-Type'] === 'application/json') {
                $paramsString = json_encode($params);
            } else {
                $paramsString = http_build_query($params);
            }
        }

        $body = null;
        if (is_string($paramsString) && $paramsString !== null) {
            $body = $paramsString;
        }

        if (is_string($params) && $params !== null) {
            $body = $params;
        }

        // change the response format
        if ($this->getApiVersion() === '1.0' && strpos($endpoint, 'format=') === false) {
            $endpoint .= (strpos($endpoint, '?') === false ? '?' : '&').'format='.$this->getResponseFormat();
        }

        $request = $this->messageFactory->createRequest($method, $endpoint, $headers, $body);

        return $this->getClient()->sendRequest($request);
    }

    /**
     * @return HttpMethodsClient
     */
    public function getClient()
    {
        return $this->httpClientBuilder->getHttpClient();
    }

    /**
     * @return HttpPluginClientBuilder
     */
    public function getClientBuilder()
    {
        return $this->httpClientBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseFormat()
    {
        return $this->options['format'];
    }

    /**
     * {@inheritdoc}
     */
    public function setResponseFormat($format)
    {
        if (!in_array($format, $this->options['formats'], true)) {
            throw new \InvalidArgumentException(sprintf('Unsupported response format %s', $format));
        }

        $this->options['format'] = $format;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiVersion()
    {
        return $this->options['api_version'];
    }

    /**
     * {@inheritdoc}
     */
    public function setApiVersion($version)
    {
        if (!in_array($version, $this->options['api_versions'], true)) {
            throw new \InvalidArgumentException(sprintf('Unsupported API version %s', $version));
        }

        if (!$this->isApiVersion($version) || !$this->httpClientBuilder->hasPlugin(ApiVersionPlugin::class)) {
            $this->options['api_version'] = $version;

            $this->httpClientBuilder->removePlugin(ApiVersionPlugin::class);
            $this->httpClientBuilder->addPlugin(new ApiVersionPlugin($this->options['api_version']));
        }

        return $this;
    }

    /**
     * Check if specified API version is the one currently in use.
     *
     * @param  string $version
     * @return bool
     */
    public function isApiVersion($version)
    {
        return (float) $version === (float) $this->options['api_version'];
    }

    /**
     * @return string
     */
    public function getApiBaseUrl()
    {
        return $this->options['base_url'].'/'.$this->getApiVersion();
    }

    /**
     * @return RequestInterface
     */
    public function getLastRequest()
    {
        return $this->responseHistory->getLastRequest();
    }

    /**
     * @return ResponseInterface
     */
    public function getLastResponse()
    {
        return $this->responseHistory->getLastResponse();
    }
}
