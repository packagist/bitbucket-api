<?php
/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru Guzinschi <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Http\Plugin;

use Bitbucket\API\Exceptions\ForbiddenAccessException;
use Bitbucket\API\Exceptions\HttpResponseException;
use Bitbucket\API\Http\Client;
use Bitbucket\API\Http\ClientInterface;
use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class OAuth2Plugin implements Plugin
{
    use Plugin\VersionBridgePlugin;

    const ENDPOINT_ACCESS_TOKEN     = '/oauth2/access_token';
    const ENDPOINT_AUTHORIZE        = '/oauth2/authorize';

    /** @var array */
    private $config = array(
        'oauth_client_id'       => 'anon',
        'oauth_client_secret'   => 'anon',
        'token_type'            => 'bearer',
        'scopes'                => array()
    );

    /** @var ClientInterface */
    private $httpClient;

    public function __construct(array $config, ClientInterface $client = null)
    {
        $this->config       = array_merge($this->config, $config);
        $this->httpClient   = (null !== $client) ? $client : new Client(
            array(
                'base_url'      => 'https://bitbucket.org',
                'api_version'   => 'site',
                'api_versions'  => array('site')
            )
        );
    }

    /**
     * {@inheritDoc}
     *
     * @throws ForbiddenAccessException
     * @throws \InvalidArgumentException
     */
    protected function doHandleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $oauth2Header = $request->getHeader('Authorization');
        foreach ($oauth2Header as $header) {
            if (strpos($header, 'Bearer') !== false) {
                return $next($request);
            }
        }

        if (false === array_key_exists('access_token', $this->config)) {
            try {
                $data = $this->getAccessToken();
                $this->config['token_type']     = $data['token_type'];
                $this->config['access_token']   = $data['access_token'];
            } catch (HttpResponseException $e) {
                throw new ForbiddenAccessException("Can't fetch access_token.", 0, $e);
            }
        }

        $request = $request->withHeader(
            'Authorization',
            sprintf(
                '%s %s',
                ucfirst(strtolower($this->config['token_type'])),
                $this->config['access_token']
            )
        );

        return $next($request);
    }

    /**
     * Fetch access token with a grant_type of client_credentials
     *
     * @access public
     * @return array
     *
     * throws \InvalidArgumentException
     * @throws HttpResponseException
     */
    protected function getAccessToken()
    {
        $response = $this->httpClient
            ->post(
                self::ENDPOINT_ACCESS_TOKEN,
                array(
                    'grant_type'    => 'client_credentials',
                    'client_id'     => $this->config['client_id'],
                    'client_secret' => $this->config['client_secret'],
                    'scope'         => implode(',', $this->config['scopes'])
                )
            )
        ;

        $contents = $response->getBody()->getContents();
        $data = json_decode($contents, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $ex = new HttpResponseException('[access_token] Invalid JSON: '. json_last_error_msg());
            $ex
                ->setResponse($response)
                ->setRequest($this->httpClient->getLastRequest())
            ;

            throw $ex;
        }

        if (false === array_key_exists('access_token', $data)) {
            throw new HttpResponseException('access_token is missing from response. '. $contents);
        }

        return $data;
    }
}
