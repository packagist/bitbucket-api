<?php
/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru Guzinschi <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitbucket\API\Repositories;

use Bitbucket\API;
use Psr\Http\Message\ResponseInterface;

/**
 * @author  Kevin Howe    <kjhowe@gmail.com>
 */
class Refs extends API\Api
{
    /**
     * Get a list of refs
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  array            $params  GET parameters
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function all($account, $repo, array $params = array())
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/refs', $account, $repo),
            $params
        );
    }
}
