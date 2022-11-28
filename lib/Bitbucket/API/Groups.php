<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API;

use Bitbucket\API\Groups\Members;
use Psr\Http\Message\ResponseInterface;

/**
 * Provides functionality for querying information about groups,
 * creating new ones, updating memberships, and deleting them.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 * @see https://confluence.atlassian.com/bitbucket/groups-endpoint-296093143.html
 */
class Groups extends Api
{
    /**
     * Get a list of groups.
     *
     * If `$filters` is not omitted, will return a list of matching groups.
     *
     * <example>
     * $filters = array(
     *     'group' => array('account_name/group_slug', 'other_account/group_slug')
     * );
     * </example>
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  array            $filters
     * @return ResponseInterface
     */
    public function get($account, array $filters = array())
    {
        // Default: fetch groups list
        $endpoint = sprintf('/groups/%s/', $account);

        if (!empty($filters)) {
            $endpoint = '/groups';

            if (isset($filters['group']) && is_array($filters['group'])) {
                $filters['group'] = implode('&group=', $filters['group']);
            }
        }

        return $this->getClient()->setApiVersion('1.0')->get($endpoint, $filters);
    }

    /**
     * Create a new group
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $name    The name of the group.
     * @return ResponseInterface
     */
    public function create($account, $name)
    {
        return $this->getClient()->setApiVersion('1.0')->post(
            sprintf('/groups/%s/', $account),
            array('name' => $name)
        );
    }

    /**
     * Update a group
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $name    The name of the group.
     * @param  array            $params
     * @return ResponseInterface
     */
    public function update($account, $name, array $params)
    {
        return $this->getClient()->setApiVersion('1.0')->put(
            sprintf('/groups/%s/%s/', $account, $name),
            $params
        );
    }

    /**
     * Delete a group
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $name    The name of the group.
     * @return ResponseInterface
     */
    public function delete($account, $name)
    {
        return $this->getClient()->setApiVersion('1.0')->delete(
            sprintf('/groups/%s/%s/', $account, $name)
        );
    }

    /**
     * Get members
     *
     * @return Groups\Members
     *
     * @throws \InvalidArgumentException
     * @codeCoverageIgnore
     */
    public function members()
    {
        return new Members([], $this->getClient());
    }
}
