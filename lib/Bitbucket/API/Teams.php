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
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class Teams extends Api
{
    /**
     * Get a list of teams to which the caller has access.
     *
     * @param  string           $role Will only return teams on which the user has the specified role.
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function all($role)
    {
        if (!is_string($role)) {
            throw new \InvalidArgumentException(sprintf('Expected $role of type string and got %s', gettype($role)));
        }

        if (!in_array(strtolower($role), array('member', 'contributor', 'admin'), true)) {
            throw new \InvalidArgumentException(sprintf('Unknown role %s', $role));
        }

        return $this->getClient()->setApiVersion('2.0')->get('/teams', array('role' => $role));
    }

    /**
     * Get the public information associated with a team.
     *
     * @param  string           $name The team's name.
     * @return ResponseInterface
     */
    public function profile($name)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s', $name)
        );
    }

    /**
     * Get the team members.
     *
     * @param  string           $name The team's name.
     * @return ResponseInterface
     */
    public function members($name)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s/members', $name)
        );
    }

    /**
     * Get the team followers list.
     *
     * @param  string           $name The team's name.
     * @return ResponseInterface
     */
    public function followers($name)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s/followers', $name)
        );
    }

    /**
     * Get a list of accounts the team is following.
     *
     * @param  string           $name The team's name.
     * @return ResponseInterface
     */
    public function following($name)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s/following', $name)
        );
    }

    /**
     * Get the team's repositories.
     *
     * @param  string           $name The team's name.
     * @return ResponseInterface
     */
    public function repositories($name)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s/repositories', $name)
        );
    }

    /**
     * @return Teams\Hooks
     * @throws \InvalidArgumentException
     */
    public function hooks()
    {
        return new Teams\Hooks([], $this->getClient());
    }

    /**
     * @return Teams\Permissions
     * @throws \InvalidArgumentException
     */
    public function permissions()
    {
        return new Teams\Permissions([], $this->getClient());
    }
}
