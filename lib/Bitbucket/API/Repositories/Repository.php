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
 * Allows you to create a new repository or edit a specific one.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class Repository extends API\Api
{
    /**
     * Get information associated with an individual repository.
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @return ResponseInterface
     */
    public function get($account, $repo)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s', $account, $repo)
        );
    }

    /**
     * Create a new repository
     *
     * If `$params` are omitted, a private git repository will be created,
     * with a "no forking" policy.
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  array|string     $params  Additional parameters as array or JSON string
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException If invalid JSON is provided.
     *
     * @see https://confluence.atlassian.com/x/WwZAGQ
     */
    public function create($account, $repo, $params = array())
    {
        $defaults = array(
            'scm'               => 'git',
            'name'              => $repo,
            'is_private'        => true,
            'description'       => 'My secret repo',
            'fork_policy'       => 'no_forks',
        );

        // allow developer to directly specify params as json if (s)he wants.
        if ('array' !== gettype($params)) {
            if (empty($params)) {
                throw new \InvalidArgumentException('Invalid JSON provided.');
            }

            $params = $this->decodeJSON($params);
        }

        $params = json_encode(array_merge($defaults, $params));

        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s', $account, $repo),
            $params,
            array('Content-Type' => 'application/json')
        );
    }

    /**
     * Update a repository
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  array            $params  Additional parameters
     * @return ResponseInterface
     *
     * @see https://confluence.atlassian.com/x/WwZAGQ
     */
    public function update($account, $repo, array $params = array())
    {
        return $this->getClient()->setApiVersion('2.0')->put(
            sprintf('/repositories/%s/%s', $account, $repo),
            $params
        );
    }

    /**
     * Delete a repository
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @return ResponseInterface
     */
    public function delete($account, $repo)
    {
        return $this->getClient()->setApiVersion('2.0')->delete(
            sprintf('/repositories/%s/%s', $account, $repo)
        );
    }

    /**
     * Gets the list of accounts watching a repository.
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @return ResponseInterface
     */
    public function watchers($account, $repo)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/watchers', $account, $repo)
        );
    }

    /**
     * Gets the list of repository forks.
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @return ResponseInterface
     */
    public function forks($account, $repo)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/forks', $account, $repo)
        );
    }

    /**
     * Fork a repository
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  string           $name    Fork name
     * @param  array            $params  Additional parameters
     * @return ResponseInterface
     *
     * @see https://confluence.atlassian.com/display/BITBUCKET/repository+Resource#repositoryResource-POSTanewfork
     */
    public function fork($account, $repo, $name, array $params = array())
    {
        $params['name'] = $name;

        $params = json_encode($params);

        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/forks', $account, $repo),
            $params,
            array('Content-Type' => 'application/json')
        );
    }

    /**
     * Get a list of branches associated with a repository.
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  string           $name    The name of the branch
     * @return ResponseInterface
     */
    public function branches($account, $repo, $name = '')
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/refs/branches/%s', $account, $repo, $name)
        );
    }

    /**
     * Get a pagination list of tags or tag object by name
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  string           $name    The name of the tag
     * @return ResponseInterface
     */
    public function tags($account, $repo, $name = '')
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/refs/tags/%s', $account, $repo, $name)
        );
    }

    /**
     * Get the history of a file in a changeset
     *
     * Returns the history of a file starting from the provided changeset.
     *
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  string           $node    The simple changeset node id.
     * @param  string           $path    Filename.
     * @return ResponseInterface
     */
    public function filehistory($account, $repo, $node, $path)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/filehistory/%s/%s', $account, $repo, $node, $path)
        );
    }
}
