<?php

namespace Bitbucket\API\Teams;

use Bitbucket\API\Api;
use Psr\Http\Message\ResponseInterface;

class Permissions extends Api
{
    /**
     * Get the highest permissions for every member of the team
     *
     * @param string $team The team's name or uuid.
     * @return ResponseInterface
     */
    public function all($team)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s/permissions', $team)
        );
    }

    /**
     * Get the permissions of every member for every repository of the team
     *
     * @param string $team The team's name or uuid.
     * @return ResponseInterface
     */
    public function repositories($team)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s/permissions/repositories', $team)
        );
    }

    /**
     * Get the permissions of every member for every repository of the team
     *
     * @param string $team The team's name or uuid.
     * @param string $repo The repository identifier.
     * @return ResponseInterface
     */
    public function repository($team, $repo)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s/permissions/repositories/%s', $team, $repo)
        );
    }
}
