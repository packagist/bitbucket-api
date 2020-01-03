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

use Buzz\Message\MessageInterface;

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
     * @return MessageInterface
     *
     * @throws \InvalidArgumentException
     */
    public function get()
    {
        return $this->getClient()->setApiVersion('2.0')->get('user/');
    }

    /**
     * Get repositories
     *
     * @access public
     * @return User\Repositories
     *
     * @throws \InvalidArgumentException
     * @codeCoverageIgnore
     */
    public function repositories()
    {
        return $this->api('User\\Repositories');
    }

    /**
     * Retrieves the email for an authenticated user.
     *
     * @access public
     * @return MessageInterface
     *
     * @throws \InvalidArgumentException
     */
    public function emails()
    {
        return $this->getClient()->setApiVersion('2.0')->get('user/emails');
    }
}
