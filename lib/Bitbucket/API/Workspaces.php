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
}
