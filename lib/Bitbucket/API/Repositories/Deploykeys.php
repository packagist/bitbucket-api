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
 * Manage ssh keys used for deploying product builds.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class Deploykeys extends API\Api
{
    /**
     * Get a list of keys
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @return ResponseInterface
     */
    public function all($account, $repo)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/deploy-keys', $account, $repo)
        );
    }

    /**
     * Get the key's content
     *
     * TIP: You can use `$this->all()` to obtain assigned `$keyId`.
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  string           $keyId   The key identifier assigned by Bitbucket.
     * @return ResponseInterface
     */
    public function get($account, $repo, $keyId)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s/%s/deploy-keys/%s', $account, $repo, $keyId)
        );
    }

    /**
     * Add a new key
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  string           $key     The content of the key.
     * @param  string           $label   A display name for the key. (optional)
     * @return ResponseInterface
     */
    public function create($account, $repo, $key, $label = null)
    {
        $options = array('key' => $key);

        if (!is_null($label)) {
            $options['label'] = $label;
        }

        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/repositories/%s/%s/deploy-keys', $account, $repo),
            $options
        );
    }

    /**
     * Update an existing key
     *
     * Available `$options`:
     *
     * <example>
     * 'label'  (string) = A display name for the key.
     * 'key'    (string) = The content of the key.
     * </example>
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  string           $keyId   The key identifier assigned by Bitbucket.
     * @param  array            $options The rest of available options
     * @return ResponseInterface
     */
    public function update($account, $repo, $keyId, $options = array())
    {
        return $this->getClient()->setApiVersion('2.0')->put(
            sprintf('/repositories/%s/%s/deploy-keys/%s', $account, $repo, $keyId),
            $options
        );
    }

    /**
     * Delete a key
     *
     * TIP: You can use `$this->all()` to obtain assigned `$keyId`.
     *
     * @access public
     * @param  string           $account The team or individual account owning the repository.
     * @param  string           $repo    The repository identifier.
     * @param  string           $keyId   The key identifier assigned by Bitbucket.
     * @return ResponseInterface
     */
    public function delete($account, $repo, $keyId)
    {
        return $this->getClient()->setApiVersion('2.0')->delete(
            sprintf('/repositories/%s/%s/deploy-keys/%s', $account, $repo, $keyId)
        );
    }
}
