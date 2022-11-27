<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Repositories;

use Bitbucket\API;
use Psr\Http\Message\ResponseInterface;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class Milestones extends API\Api
{
    /**
     * Get a list of milestones
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @return ResponseInterface
     */
    public function all($account, $repo)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/milestones', $account, $repo)
        );
    }

    /**
     * Get an individual milestone
     *
     * @param  string           $account     The team or individual account owning the repository.
     * @param  string           $repo        The repository identifier.
     * @param  int              $milestoneID The milestone identifier.
     * @return ResponseInterface
     */
    public function get($account, $repo, $milestoneID)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/milestones/%d', $account, $repo, $milestoneID)
        );
    }
}
