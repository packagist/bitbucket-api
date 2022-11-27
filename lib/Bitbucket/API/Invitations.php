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
 * Allows repository administrators to send email invitations to
 * grant read, write, or admin privileges to a repository.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 * @see https://confluence.atlassian.com/bitbucket/invitations-endpoint-296093147.html
 */
class Invitations extends Api
{
    /**
     * Sending an invite
     *
     * @param  string           $account    The team or individual account.
     * @param  string           $repo       A repository belonging to the account.
     * @param  string           $email      The email recipient.
     * @param  string           $permission The permission the recipient is granted.
     * @return ResponseInterface
     */
    public function send($account, $repo, $email, $permission)
    {
        return $this->getClient()->setApiVersion('1.0')->post(
            sprintf('/invitations/%s/%s', $account, $repo),
            ['permission' => $permission, 'email' => $email]
        );
    }
}
