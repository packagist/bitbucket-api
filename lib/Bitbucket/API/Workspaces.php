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
 * @author  Matt S.    <matt@mattonline.me>
 */
class Workspaces extends Api
{
    /**
     * Get a list of workspaces to which the caller has access.
     *
     * @access public
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function all()
    {
        return $this->getClient()->setApiVersion('2.0')->get('/workspaces');
    }

    /**
     * Get the public information associated with a workspace.
     *
     * @access public
     * @param  string           $workspace The workspace ID (slug) or workspace UUID in curly brackets.
     * @return ResponseInterface
     */
    public function profile($workspace)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/workspaces/%s', $workspace)
        );
    }

    /**
     * Get the workspace members.
     *
     * @access public
     * @param  string           $workspace The workspace ID (slug) or workspace UUID in curly brackets.
     * @return ResponseInterface
     */
    public function members($workspace)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/workspaces/%s/members', $workspace)
        );
    }

    /**
     * Get the list of projects in the workspace
     *
     * @access public
     * @param  string           $workspace The workspace ID (slug) or workspace UUID in curly brackets.
     * @return ResponseInterface
     */
    public function projects($workspace)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/workspaces/%s/projects', $workspace)
        );
    }

    /**
     * @return Workspaces\Hooks
     * @throws \InvalidArgumentException
     */
    public function hooks()
    {
        return $this->api(Workspaces\Hooks::class);
    }
}
