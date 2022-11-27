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
 * Manage the comments on pull requests.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class PullRequests extends API\Api
{
    /**
     * Get comments
     *
     * @return PullRequests\Comments
     *
     * @throws \InvalidArgumentException
     * @codeCoverageIgnore
     */
    public function comments()
    {
        return new PullRequests\Comments([], $this->getClient());
    }

    /**
     * Get a list of pull requests
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  array            $params  Additional parameters
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function all($account, $repo, array $params = array())
    {
        $states = array('OPEN', 'MERGED', 'DECLINED');
        $params = array_merge(
            array(
                'state' => 'OPEN'
            ),
            $params
        );

        if (!is_array($params['state'])) {
            $params['state'] = array($params['state']);
        }

        array_walk(
            $params['state'],
            function ($state) use ($states) {
                if (!in_array($state, $states)) {
                    throw new \InvalidArgumentException(sprintf('Unknown `state` %s', $state));
                }
            }
        );

        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/pullrequests', $account, $repo),
            $params
        );
    }

    /**
     * Create a new pull request
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  array|string     $params  Additional parameters as array or JSON string
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     * @see https://confluence.atlassian.com/x/XAZAGQ
     */
    public function create($account, $repo, $params = array())
    {
        $defaults = array(
            'title' => 'New pull request',
            'source' => array(
                'branch' => array(
                    'name'  => 'develop'
                )
            )
        );

        // allow developer to directly specify params as json if (s)he wants.
        if ('array' !== gettype($params)) {
            if (empty($params)) {
                throw new \InvalidArgumentException('Invalid JSON provided.');
            }

            $params = $this->decodeJSON($params);
        }

        $params = array_merge($defaults, $params);

        if (empty($params['title'])) {
            throw new \InvalidArgumentException('Pull request\'s title must be specified.');
        }

        if (empty($params['source']['branch']['name'])) {
            throw new \InvalidArgumentException('Pull request\'s source branch name must be specified.');
        }

        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/pullrequests', $account, $repo),
            json_encode($params),
            array('Content-Type' => 'application/json')
        );
    }

    /**
     * Update a pull request
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      ID of the pull request that will be updated
     * @param  array|string     $params  Additional parameters as array or JSON string
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function update($account, $repo, $id, $params = array())
    {
        $defaults = array(
            'title' => 'Updated pull request',
            'destination' => array(
                'branch' => array(
                    'name'  => 'develop'
                )
            )
        );

        // allow developer to directly specify params as json if (s)he wants.
        if ('array' !== gettype($params)) {
            if (empty($params)) {
                throw new \InvalidArgumentException('Invalid JSON provided.');
            }

            $params = $this->decodeJSON($params);
        }

        $params = array_merge($defaults, $params);

        if (empty($params['title'])) {
            throw new \InvalidArgumentException('Pull request\'s title must be specified.');
        }

        if (empty($params['destination']['branch']['name'])) {
            throw new \InvalidArgumentException('Pull request\'s destination branch name must be specified.');
        }

        return $this->getClient()->setApiVersion('2.0')->put(
            sprintf('/repositories/%s/%s/pullrequests/%d', $account, $repo, $id),
            json_encode($params),
            array('Content-Type' => 'application/json')
        );
    }

    /**
     * Get a specific pull request
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      ID of the pull request
     * @return ResponseInterface
     */
    public function get($account, $repo, $id)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/pullrequests/%d', $account, $repo, $id)
        );
    }

    /**
     * Get the commits for a pull request
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      ID of the pull request
     * @return ResponseInterface
     */
    public function commits($account, $repo, $id)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/pullrequests/%d/commits', $account, $repo, $id)
        );
    }

    /**
     * Approve a pull request
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      ID of the pull request
     * @return ResponseInterface
     */
    public function approve($account, $repo, $id)
    {
        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/pullrequests/%d/approve', $account, $repo, $id)
        );
    }

    /**
     * Delete a pull request approval
     *
     * NOTE: On success returns `HTTP/1.1 204 NO CONTENT`
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      ID of the pull request
     * @return ResponseInterface
     */
    public function deleteApproval($account, $repo, $id)
    {
        return $this->getClient()->setApiVersion('2.0')->delete(
            sprintf('/repositories/%s/%s/pullrequests/%d/approve', $account, $repo, $id)
        );
    }

    /**
     * Get the diff for a pull request
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      ID of the pull request
     * @return ResponseInterface
     */
    public function diff($account, $repo, $id)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/pullrequests/%d/diff', $account, $repo, $id)
        );
    }

    /**
     * Get the diff stat for a pull request
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      ID of the pull request
     * @return ResponseInterface
     */
    public function diffstat($account, $repo, $id)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/pullrequests/%d/diffstat', $account, $repo, $id)
        );
    }

    /**
     * Get the log of all of a repository's pull request activity
     *
     * If `$id` is omitted the repository's pull request activity is returned.
     * If `$id` is not omitted the pull request activity is returned.
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      (Optional) ID of the pull request
     * @return ResponseInterface
     */
    public function activity($account, $repo, $id = 0)
    {
        $endpoint = sprintf('/repositories/%s/%s/pullrequests/', $account, $repo);

        if ($id === 0) {
            $endpoint .= 'activity';
        } else {
            $endpoint .= $id.'/activity';
        }

        return $this->getClient()->setApiVersion('2.0')->get($endpoint);
    }

    /**
     * Accept and merge a pull request
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      (Optional) ID of the pull request
     * @param  array            $params  Additional parameters.
     * @return ResponseInterface
     */
    public function accept($account, $repo, $id, $params = array())
    {
        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/pullrequests/%d/merge', $account, $repo, $id),
            json_encode($params),
            array('Content-Type' => 'application/json')
        );
    }

    /**
     * Decline a pull request
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  int              $id      (Optional) ID of the pull request
     * @param  array            $params  Additional parameters.
     * @return ResponseInterface
     */
    public function decline($account, $repo, $id, $params = array())
    {
        if (false === array_key_exists('message', $params)) {
            $params['message'] = '';
        }

        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/pullrequests/%d/decline', $account, $repo, $id),
            json_encode($params),
            array('Content-Type' => 'application/json')
        );
    }
}
