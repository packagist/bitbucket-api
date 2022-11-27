<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Workspaces;

use Bitbucket\API;
use Psr\Http\Message\ResponseInterface;

/**
 * @author  Matt S.    <matt@mattonline.me>
 */
class Workspace extends API\Api
{
    /**
     * Get the public information associated with a workspace.
     *
     * @param  string           $workspace The workspace ID (slug) or workspace UUID in curly brackets.
     * @return ResponseInterface
     */
    public function workspace($workspace)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/workspaces/%s', $workspace)
        );
    }

    /**
     * Get the workspace members.
     *
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
     * @return Hooks
     * @throws \InvalidArgumentException
     */
    public function hooks()
    {
        return new Hooks([], $this->getClient());
    }
}
