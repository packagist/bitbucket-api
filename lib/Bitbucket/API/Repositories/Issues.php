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
use Bitbucket\API\Repositories;
use Buzz\Message\MessageInterface;

/**
 * Provides functionality for interacting with an issue tracker.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class Issues extends API\Api
{
    /**
     * GET a list of issues in a repository's tracker
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  array            $options Filtering parameters.
     * @return MessageInterface
     *
     * @see https://confluence.atlassian.com/x/1w2mEQ
     */
    public function all($account, $repo, array $options = array())
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/issues', $account, $repo),
            $options
        );
    }

    /**
     * GET an individual issue
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $issueID The issue identifier.
     * @return MessageInterface
     */
    public function get($account, $repo, $issueID)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/issues/%d', $account, $repo, $issueID)
        );
    }

    /**
     * POST a new issue
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  array            $options Issue parameters
     * @return MessageInterface
     *
     * @throws \InvalidArgumentException
     *
     * @see https://confluence.atlassian.com/display/BITBUCKET/issues+Resource#issuesResource-POSTanewissue
     */
    public function create($account, $repo, array $options = array())
    {
        if (!isset($options['title']) || !isset($options['content'])) {
            throw new \InvalidArgumentException(
                'Arguments: "title" and "content" are mandatory.'
            );
        }

        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/issues', $account, $repo),
            $options
        );
    }

    /**
     * Update existing issue
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $issueID The issue identifier.
     * @param  array            $options Issue parameters
     * @return MessageInterface
     *
     * @see https://confluence.atlassian.com/display/BITBUCKET/issues+Resource#issuesResource-Updateanexistingissue
     */
    public function update($account, $repo, $issueID, array $options)
    {
        return $this->getClient()->setApiVersion('2.0')->put(
            sprintf('/repositories/%s/%s/issues/%d', $account, $repo, $issueID),
            $options
        );
    }

    /**
     * Delete issue
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $issueID The issue identifier.
     * @return MessageInterface
     */
    public function delete($account, $repo, $issueID)
    {
        return $this->getClient()->setApiVersion('2.0')->delete(
            sprintf('/repositories/%s/%s/issues/%d', $account, $repo, $issueID)
        );
    }

    /**
     * Get comments
     *
     * @access public
     * @return Repositories\Issues\Comments
     *
     * @throws \InvalidArgumentException
     * @codeCoverageIgnore
     */
    public function comments()
    {
        return $this->api('Repositories\\Issues\\Comments');
    }
}
