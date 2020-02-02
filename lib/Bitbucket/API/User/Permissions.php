<?php

namespace Bitbucket\API\User;

use Bitbucket\API\Api;
use Psr\Http\Message\ResponseInterface;

class Permissions extends Api
{
    /**
     * Get the list of the user's team permissions
     *
     * @return ResponseInterface
     */
    public function teams()
    {
        return $this->getClient()->setApiVersion('2.0')->get('/user/permissions/teams');
    }

    /**
     * Get the list of the user's repository permissions
     *
     * @return ResponseInterface
     */
    public function repositories()
    {
        return $this->getClient()->setApiVersion('2.0')->get('/user/permissions/repositories');
    }
}
