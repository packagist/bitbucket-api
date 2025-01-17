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
    /** @deprecated */
    const HTTP_RESPONSE_OK              = 200;
    /** @deprecated */
    const HTTP_RESPONSE_CREATED         = 201;
    /** @deprecated */
    const HTTP_RESPONSE_NO_CONTENT      = 204;
    /** @deprecated */
    const HTTP_RESPONSE_BAD_REQUEST     = 400;
    /** @deprecated */
    const HTTP_RESPONSE_UNAUTHORIZED    = 401;
    /** @deprecated */
    const HTTP_RESPONSE_FORBIDDEN       = 403;
    /** @deprecated */
    const HTTP_RESPONSE_NOT_FOUND       = 404;

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
     * Set the preferred format for response
     *
     * @param  string $name Format name
     * @return self
     *
     * @deprecated Usage of response format other than JSON will be removed with 3.0
     * @throws \InvalidArgumentException
     */
    public function setFormat($name)
    {
        $this->getClient()->setResponseFormat($name);

        return $this;
    }

    /**
     * Get current format used for response
     * @deprecated Usage of response format other than JSON will be removed with 3.0
     * @return string
     */
    public function getFormat()
    {
        return $this->getClient()->getResponseFormat();
    }

    /**
     * @param  string $name
     * @return Api
     *
     * @throws \InvalidArgumentException
     */
    public function api($name)
    {
        if (!is_string($name) || $name === '') {
            throw new \InvalidArgumentException('No child specified.');
        }

        if (class_exists($name)) {
            $class = $name;
        } else {
            trigger_deprecation('private-packagist/bitbucket-api', '2.2', 'Calling Api::api() with a string instead of a fully qualified class name is deprecated.');

            $class = '\\Bitbucket\\API\\'.$name;

            if (!class_exists($class)) {
                throw new \InvalidArgumentException(sprintf('No such child class [%s].', $name));
            }
        }

        /** @var Api $child */
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
