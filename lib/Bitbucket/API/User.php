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
 * Manages the currently authenticated account profile.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class User extends Api
{
    /**
     * Get user profile
     *
     * @access public
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function get()
    {
        return $this->getClient()->setApiVersion('2.0')->get('/user/');
    }

    /**
     * Retrieves the email for an authenticated user.
     *
     * @access public
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function emails()
    {
        return $this->getClient()->setApiVersion('2.0')->get('/user/emails');
    }

    /**
     * @return User\Permissions
     * @throws \InvalidArgumentException
     */
    public function permissions()
    {
        return $this->api(User\Permissions::class);
    }
}
