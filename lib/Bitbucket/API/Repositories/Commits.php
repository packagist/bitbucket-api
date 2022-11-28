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

use Bitbucket\API\Api;
use Bitbucket\API\Repositories\Commits\Comments;
use Psr\Http\Message\ResponseInterface;

/**
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class Commits extends Api
{
    /**
     * Get a list of commits
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  array            $params  Additional parameters
     * @return ResponseInterface
     */
    public function all($account, $repo, array $params = array())
    {
        $endpoint = sprintf('/repositories/%s/%s/commits', $account, $repo);

        if (!empty($params['branch'])) {
            $endpoint .= '/'.$params['branch']; // can also be a tag
            unset($params['branch']);
        }

        return $this->getClient()->setApiVersion('2.0')->get(
            $endpoint,
            $params
        );
    }

    /**
     * Get an individual commit
     *
     * @param  string           $account  The team or individual account owning the repository.
     * @param  string           $repo     The repository identifier.
     * @param  string           $revision A SHA1 value for the commit.
     * @return ResponseInterface
     */
    public function get($account, $repo, $revision)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/commit/%s', $account, $repo, $revision)
        );
    }

    /**
     * Approve a commit
     *
     * @param  string           $account  The team or individual account owning the repository.
     * @param  string           $repo     The repository identifier.
     * @param  string           $revision A SHA1 value for the commit.
     * @return ResponseInterface
     */
    public function approve($account, $repo, $revision)
    {
        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/commit/%s/approve', $account, $repo, $revision)
        );
    }

    /**
     * Delete a commit approval
     *
     * NOTE: On success returns `HTTP/1.1 204 NO CONTENT`
     *
     * @param  string           $account  The team or individual account owning the repository.
     * @param  string           $repo     The repository identifier.
     * @param  string           $revision A SHA1 value for the commit.
     * @return ResponseInterface
     */
    public function deleteApproval($account, $repo, $revision)
    {
        return $this->getClient()->setApiVersion('2.0')->delete(
            sprintf('/repositories/%s/%s/commit/%s/approve', $account, $repo, $revision)
        );
    }

    /**
     * Get comments
     *
     * @return Commits\Comments
     *
     * @throws \InvalidArgumentException
     * @codeCoverageIgnore
     */
    public function comments()
    {
        return new Comments([], $this->getClient());
    }
}
