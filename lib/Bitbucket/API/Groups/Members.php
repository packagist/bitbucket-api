<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Groups;

use Bitbucket\API;
use Psr\Http\Message\ResponseInterface;

/**
 * Manage group members.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 * @see https://confluence.atlassian.com/bitbucket/groups-endpoint-296093143.html
 */
class Members extends API\Api
{
    /**
     * Get the group members
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @return ResponseInterface
     */
    public function all($account, $repo)
    {
        return $this->getClient()->setApiVersion('1.0')->get(
            sprintf('/groups/%s/%s/members', $account, $repo)
        );
    }

    /**
     * Add new member into a group.
     *
     * @param  string           $account    The team or individual account owning the repository.
     * @param  string           $groupSlug  The slug of the group.
     * @param  string           $memberUuid An individual account.
     * @return ResponseInterface
     */
    public function add($account, $groupSlug, $memberUuid)
    {
        return $this->getClient()->setApiVersion('1.0')->put(
            sprintf('/groups/%s/%s/members/%s', $account, $groupSlug, $memberUuid)
        );
    }

    /**
     * Delete a member from group.
     *
     * @param  string           $account    The team or individual account owning the repository.
     * @param  string           $groupSlug  The slug of the group.
     * @param  string           $memberUuid An individual account.
     * @return ResponseInterface
     */
    public function delete($account, $groupSlug, $memberUuid)
    {
        return $this->getClient()->setApiVersion('1.0')->delete(
            sprintf('/groups/%s/%s/members/%s', $account, $groupSlug, $memberUuid)
        );
    }
}
