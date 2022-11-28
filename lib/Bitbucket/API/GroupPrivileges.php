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

use Psr\Http\Message\ResponseInterface;

/**
 * Manages a group's repository permissions.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 * @see https://confluence.atlassian.com/bitbucket/group-privileges-endpoint-296093137.html
 */
class GroupPrivileges extends Api
{
    /**
     * Get a list of privileged groups
     *
     * Gets all the groups granted access to an account's repositories.
     *
     * @param  string           $workspaceId The team or individual account owning the repository.
     * @return ResponseInterface
     */
    public function groups($workspaceId)
    {
        return $this->getClient()->setApiVersion('1.0')->get(
            sprintf('/group-privileges/%s/', $workspaceId)
        );
    }

    /**
     * Get a list of privileged groups for a repository
     *
     * Get a list of the privilege groups for a specific repository.
     *
     * @param  string           $workspaceId The team or individual account owning the repository.
     * @param  string           $repo        A repository belonging to the account.
     * @return ResponseInterface
     */
    public function repository($workspaceId, $repo)
    {
        return $this->getClient()->setApiVersion('1.0')->get(
            sprintf('/group-privileges/%s/%s', $workspaceId, $repo)
        );
    }

    /**
     * Get a group on a repository
     *
     * Gets the privileges of a group on a repository.
     *
     * @param  string           $workspaceId The team or individual account owning the repository.
     * @param  string           $repo        A repository belonging to the account.
     * @param  string           $groupOwner  The account that owns the group.
     * @param  string           $groupSlug   The group slug.
     * @return ResponseInterface
     */
    public function group($workspaceId, $repo, $groupOwner, $groupSlug)
    {
        return $this->getClient()->setApiVersion('1.0')->get(
            sprintf('/group-privileges/%s/%s/%s/%s', $workspaceId, $repo, $groupOwner, $groupSlug)
        );
    }

    /**
     * Get a list of repositories with a specific privilege group
     *
     * Get a list of the repositories on which a particular privilege group appears.
     *
     * @param  string           $workspaceId The team or individual account owning the repository.
     * @param  string           $groupOwner  The account that owns the group.
     * @param  string           $groupSlug   The group slug.
     * @return ResponseInterface
     */
    public function repositories($workspaceId, $groupOwner, $groupSlug)
    {
        return $this->getClient()->setApiVersion('1.0')->get(
            sprintf('/group-privileges/%s/%s/%s', $workspaceId, $groupOwner, $groupSlug)
        );
    }

    /**
     *
     * Grant group privileges on a repository.
     *
     * @param  string           $workspaceId The team or individual account owning the repository.
     * @param  string           $repo        The repository to grant privileges on.
     * @param  string           $groupOwner  The account that owns the group.
     * @param  string           $groupSlug   The group slug.
     * @param  string           $privilege   A privilege value
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function grant($workspaceId, $repo, $groupOwner, $groupSlug, $privilege)
    {
        if (!in_array($privilege, array('read', 'write', 'admin'))) {
            throw new \InvalidArgumentException("Invalid privilege provided.");
        }

        return $this->getClient()->setApiVersion('1.0')->put(
            sprintf('/group-privileges/%s/%s/%s/%s', $workspaceId, $repo, $groupOwner, $groupSlug),
            $privilege
        );
    }

    /**
     * Delete group privileges from a repository
     *
     * @param  string           $workspaceId The team or individual account.
     * @param  string           $repo        The repository to remove privileges from.
     * @param  string           $groupOwner  The account that owns the group.
     * @param  string           $groupSlug   The group slug.
     * @return ResponseInterface
     */
    public function delete($workspaceId, $repo, $groupOwner, $groupSlug)
    {
        return $this->getClient()->setApiVersion('1.0')->delete(
            sprintf('/group-privileges/%s/%s/%s/%s', $workspaceId, $repo, $groupOwner, $groupSlug)
        );
    }
}
