<?php
/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru Guzinschi <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API;

use Bitbucket\API\Http\Plugin\ApiOneCollectionPlugin;
use Bitbucket\API\Http\ClientInterface;
use Bitbucket\API\Http\Client;
use Bitbucket\API\Http\Plugin\NormalizeArrayPlugin;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Message\Authentication;
use Psr\Http\Message\MessageInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 * @phpstan-import-type OptionalClientOption from Client
 */
class Api
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @param OptionalClientOption $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = array(), ClientInterface $client = null)
    {
        $this->httpClient = (null !== $client) ? $client : new Client($options, null);

        $this->addPlugin(new NormalizeArrayPlugin());
        $this->addPlugin(new ApiOneCollectionPlugin());
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->httpClient;
    }

    /**
     * @param  ClientInterface $client
     * @return $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Set API login credentials
     *
     * @param  Authentication $authentication
     * @return void
     */
    public function setCredentials(Authentication $authentication)
    {
        $this->addPlugin(new AuthenticationPlugin($authentication));
    }

    /**
     * @return void
     */
    public function addPlugin(Plugin $plugin)
    {
        $this->httpClient->getClientBuilder()->removePlugin(get_class($plugin));
        $this->httpClient->getClientBuilder()->addPlugin($plugin);
    }

    /**
     * Make an HTTP GET request to API
     *
     * @param  string           $endpoint API endpoint
     * @param  string|array     $params   GET parameters
     * @param  array            $headers  HTTP headers
     * @return MessageInterface
     */
    public function requestGet($endpoint, $params = array(), $headers = array())
    {
        return $this->getClient()->get($endpoint, $params, $headers);
    }

    /**
     * Make an HTTP POST request to API
     *
     * @param  string           $endpoint API endpoint
     * @param  string|array     $params   POST parameters
     * @param  array            $headers  HTTP headers
     * @return MessageInterface
     */
    public function requestPost($endpoint, $params = array(), $headers = array())
    {
        return $this->getClient()->post($endpoint, $params, $headers);
    }

    /**
     * Make an HTTP PUT request to API
     *
     * @param  string           $endpoint API endpoint
     * @param  string|array     $params   POST parameters
     * @param  array            $headers  HTTP headers
     * @return MessageInterface
     */
    public function requestPut($endpoint, $params = array(), $headers = array())
    {
        return $this->getClient()->put($endpoint, $params, $headers);
    }

    /**
     * Make a HTTP DELETE request to API
     *
     * @param  string           $endpoint API endpoint
     * @param  string|array     $params   DELETE parameters
     * @param  array            $headers  HTTP headers
     * @return MessageInterface
     */
    public function requestDelete($endpoint, $params = array(), $headers = array())
    {
        return $this->getClient()->delete($endpoint, $params, $headers);
    }

    /**
     * Create HTTP request
     *
     * @param  string           $method   HTTP method
     * @param  string           $endpoint Api endpoint
     * @param  string|array     $params   Request parameter(s)
     * @param  array            $headers  HTTP headers
     * @return MessageInterface
     *
     * @throws \RuntimeException
     */
    protected function doRequest($method, $endpoint, $params, array $headers)
    {
        return $this->getClient()->request($endpoint, $params, $method, $headers);
    }

    /**
     * @template T of \Bitbucket\API\Api
     * @param class-string<T> $class
     * @return T
     */
    public function api(string $class): Api
    {
        $child = new $class();
        $child->setClient($this->getClient());

        return $child;
    }

    /**
     * @return void
     */
    public function __clone()
    {
        // prevent reference to the same HTTP client.
        $this->setClient(clone $this->getClient());
    }

    /**
     * Convert JSON to array with error check
     *
     * @param  string $body JSON data
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function decodeJSON($body)
    {
        $params = json_decode($body, true);

        if (!is_array($params) || (JSON_ERROR_NONE !== json_last_error())) {
            throw new \InvalidArgumentException('Invalid JSON data provided.');
        }

        return $params;
    }
}
