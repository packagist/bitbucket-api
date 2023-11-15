<?php

namespace Bitbucket\API\Workspaces;

use Bitbucket\API\Api;
use Psr\Http\Message\ResponseInterface;

class Hooks extends Api
{
    /**
     * @param string $workspace The workspace ID (slug) or workspace UUID in curly brackets.
     * @param array $hookConfiguration The hook configuration
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function create($workspace, array $hookConfiguration)
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
            sprintf('/workspaces/%s/hooks', $workspace),
            $hookConfiguration,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @param string $workspace The workspace ID (slug) or workspace UUID in curly brackets.
     * @param string $uuid The universally unique identifier of the webhook.
     * @param array $hookConfiguration The hook configuration
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     */
    public function update($workspace, $uuid, array $hookConfiguration)
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
            sprintf('/workspaces/%s/hooks/%s', $workspace, $uuid),
            $hookConfiguration,
            ['Content-Type' => 'application/json']
        );
    }

    /**

     * @param string $workspace The workspace ID (slug) or workspace UUID in curly brackets.
     * @return ResponseInterface
     */
    public function all($workspace)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/workspaces/%s/hooks', $workspace)
        );
    }

    /**
     * @param string $workspace The workspace ID (slug) or workspace UUID in curly brackets.
     * @param string $uuid The universally unique identifier of the webhook.
     * @return ResponseInterface
     */
    public function get($workspace, $uuid)
    {
        return $this->getClient()->setApiVersion('2.0')->get(
            sprintf('/workspaces/%s/hooks/%s', $workspace, $uuid)
        );
    }

    /**
     * @param string $workspace The workspace ID (slug) or workspace UUID in curly brackets.
     * @param string $uuid The universally unique identifier of the webhook.
     * @return ResponseInterface
     */
    public function delete($workspace, $uuid)
    {
        return $this->getClient()->setApiVersion('2.0')->delete(
            sprintf('/workspaces/%s/hooks/%s', $workspace, $uuid)
        );
    }
}
