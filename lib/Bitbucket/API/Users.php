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
 * Get information related to an individual or team account.
 * NOTE: For making calls against the currently authenticated account, see the `User` resource.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class Users extends Api
{
    /**
     * Get the public information associated with a user
     *
     * @param  string           $username
     * @return ResponseInterface
     */
    public function get($username)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/users/%s', $username)
        );
    }

    /**
     * Get the list of the user's repositories
     *
     * @param  string           $username
     * @return ResponseInterface
     */
    public function repositories($username)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/repositories/%s', $username)
        );
    }

    /**
     * Get invitations
     *
     * @return Users\Invitations
     *
     * @throws \InvalidArgumentException
     */
    public function invitations()
    {
        return new Users\Invitations([], $this->getClient());
    }

    /**
     * Get sshKeys
     *
     * @return Users\SshKeys
     *
     * @throws \InvalidArgumentException
     */
    public function sshKeys()
    {
        return new Users\SshKeys([], $this->getClient());
    }
}
