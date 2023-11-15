<?php

namespace Bitbucket\API\Teams;

use Bitbucket\API\Api;
use Psr\Http\Message\ResponseInterface;

class Hooks extends Api
{
    /**
     * @param string $team The team's name or uuid.
     * @param array $hookConfiguration The hook configuration
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function create($team, array $hookConfiguration)
    {
        $mandatory = [
            'url' => '',
            'active' => true,
            'events' => [],
        ];

        $diff = array_diff(array_keys($mandatory), array_keys($hookConfiguration));
        if (count($diff) > 0) {
            throw new \InvalidArgumentException('Missing parameters for creating a new webhook.');
        }

        if (false === array_key_exists('events', $hookConfiguration) || 0 === count($hookConfiguration['events'])) {
            throw new \InvalidArgumentException('Missing events for creating a new webhook.');
        }

        return $this->getClient()->setApiVersion('2.0')->post(
            sprintf('/teams/%s/hooks', $team),
            $hookConfiguration,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @param string $team The team's name or uuid.
     * @param string $uuid The universally unique identifier of the webhook.
     * @param array $hookConfiguration The hook configuration
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function update($team, $uuid, array $hookConfiguration)
    {
        $mandatory = [
            'url' => '',
            'active' => true,
            'events' => []
        ];

        $diff = array_diff(array_keys($mandatory), array_keys($hookConfiguration));
        if (count($diff) > 0) {
            throw new \InvalidArgumentException('Missing parameters for updating a webhook.');
        }

        if (false === array_key_exists('events', $hookConfiguration) || 0 === count($hookConfiguration['events'])) {
            throw new \InvalidArgumentException('Missing events for updating a new webhook.');
        }

        return $this->getClient()->setApiVersion('2.0')->put(
            sprintf('/teams/%s/hooks/%s', $team, $uuid),
            $hookConfiguration,
            ['Content-Type' => 'application/json']
        );
    }

    /**

     * @param string $team The team's name or uuid.
     * @return ResponseInterface
     */
    public function all($team)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s/hooks', $team)
        );
    }

    /**
     * @param string $team The team's name or uuid.
     * @param string $uuid The universally unique identifier of the webhook.
     * @return ResponseInterface
     */
    public function get($team, $uuid)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/teams/%s/hooks/%s', $team, $uuid)
        );
    }

    /**
     * @param string $team The team's name or uuid.
     * @param string $uuid The universally unique identifier of the webhook.
     * @return ResponseInterface
     */
    public function delete($team, $uuid)
    {
        return $this->getClient()->setApiVersion('2.0')->delete(
            sprintf('/teams/%s/hooks/%s', $team, $uuid)
        );
    }
}
