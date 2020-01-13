<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Users;

use Bitbucket\API\Api;
use Buzz\Message\MessageInterface;

/**
 * An invitation is a request sent to an external email address to participate
 * one or more of an account's groups.
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 * @see https://confluence.atlassian.com/bitbucket/invitations-resource-296911749.html
 */
class Invitations extends Api
{
    /**
     * Get a list of pending invitations
     *
     * @access public
     * @param  string           $account The name of an individual or team account.
     * @return MessageInterface
     */
    public function all($account)
    {
        return $this->getClient()->setApiVersion('1.0')->get(
            sprintf('/users/%s/invitations', $account)
        );
    }

    /**
     * Issues an invitation to the specified account group.
     *
     * An invitation is a request sent to an external email address to participate one or more of an account's groups.
     *
     * @access public
     * @param  string           $account    The name of an individual or team account.
     * @param  string           $groupSlug  An identifier for the group.
     * @param  string           $email      Name of the email address
     * @return MessageInterface
     */
    public function create($account, $groupSlug, $email)
    {
        return $this->getClient()->setApiVersion('1.0')->put(
            sprintf('/users/%s/invitations', $account),
            ['email' => $email, 'group_slug' => $groupSlug]
        );
    }

    /**
     * Delete pending invitations by email address
     *
     * Deletes any pending invitations on a team or individual account for a particular email address.
     *
     * @access public
     * @param  string           $account The name of an individual or team account.
     * @param  string           $email   Name of the email address to delete.
     * @return MessageInterface
     */
    public function deleteByEmail($account, $email)
    {
        return $this->getClient()->setApiVersion('1.0')->delete(
            sprintf('/users/%s/invitations', $account),
            ['email' => $email]
        );
    }

    /**
     * Delete pending invitations by group
     *
     * Deletes a pending invitation for a particular email on account's group.
     *
     * @access public
     * @param  string           $account    The name of an individual or team account.
     * @param  string           $groupSlug  An identifier for the group.
     * @param  string           $email      Name of the email address to delete.
     * @return MessageInterface
     */
    public function deleteByGroup($account, $groupSlug, $email)
    {
        return $this->getClient()->setApiVersion('1.0')->delete(
            sprintf('/users/%s/invitations', $account),
            ['email' => $email, 'group_slug' => $groupSlug]
        );
    }
}
