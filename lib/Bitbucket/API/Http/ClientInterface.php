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

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 * @deprecated The ClientInterface will be removed with 3.0, depend on client directly.
 */
interface ClientInterface
{
    /**
     * Make an HTTP GET request to API
     *
     * @param  string           $endpoint API endpoint
     * @param  string|array     $params   GET parameters
     * @param  array            $headers  HTTP headers
     * @return ResponseInterface
     */
    public function get($endpoint, $params = array(), $headers = array());

    /**
     * Make an HTTP POST request to API
     *
     * @param  string           $endpoint API endpoint
     * @param  string|array     $params   POST parameters
     * @param  array            $headers  HTTP headers
     * @return ResponseInterface
     */
    public function post($endpoint, $params = array(), $headers = array());

    /**
     * Make an HTTP PUT request to API
     *
     * @param  string           $endpoint API endpoint
     * @param  string|array     $params   Put parameters
     * @param  array            $headers  HTTP headers
     * @return ResponseInterface
     */
    public function put($endpoint, $params = array(), $headers = array());

    /**
     * Make a HTTP DELETE request to API
     *
     * @param  string           $endpoint API endpoint
     * @param  string|array     $params   DELETE parameters
     * @param  array            $headers  HTTP headers
     * @return ResponseInterface
     */
    public function delete($endpoint, $params = array(), $headers = array());

    /**
     * Make a HTTP request
     *
     * @param  string           $endpoint
     * @param  string|array     $params
     * @param  string           $method
     * @param  array            $headers
     * @return ResponseInterface
     */
    public function request($endpoint, $params = array(), $method = 'GET', array $headers = array());

    /**
     * Get response format for next request
     *
     * @return string
     * @deprecated Usage of response format other than JSON will be removed with 3.0
     */
    public function getResponseFormat();

    /**
     * Set response format for next request
     *
     * Supported formats: xml, json
     *
     * @param  string $format
     * @return $this
     * @deprecated Usage of response format other than JSON will be removed with 3.0
     *
     * @throws \InvalidArgumentException If invalid response format is provided
     */
    public function setResponseFormat($format);

    /**
     * Get API version currently used
     *
     * @return string
     */
    public function getApiVersion();

    /**
     * Change used API version for next request
     *
     * Supported versions: 1.0, 2.0
     *
     * @param  string $version
     * @return $this
     *
     * @throws \InvalidArgumentException If invalid API version is provided
     */
    public function setApiVersion($version);

    /**
     * @return RequestInterface
     */
    public function getLastRequest();

    /**
     * @return HttpPluginClientBuilder
     */
    public function getClientBuilder();
}
