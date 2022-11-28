<?php

namespace Bitbucket\Tests\API\Teams;

use Bitbucket\API\Teams\Hooks;
use Bitbucket\Tests\API\TestCase;

class HooksTest extends TestCase
{
    /** @var Hooks */
    private $hooks;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hooks = $this->getApiMock(Hooks::class);
    }

    public function invalidCreateProvider(): array
    {
        return [
            [[
                'dummy' => 'data',
            ]],
            [[
                'url' => '',
                'active' => true,
            ]],
            [[
                'url' => '',
                'active' => true,
                'events' => [],
            ]],
            [[
                'url' => '',
                'events' => [
                    'event1',
                    'event2',
                ],
            ]],
            [[
                'active' => true,
                'events' => [
                    'event1',
                    'event2',
                ],
            ]],
        ];
    }

    /**
     * @dataProvider invalidCreateProvider
     */
    public function testInvalidCreate(array $check): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hooks->create('gentle', $check);
    }

    public function testCreateSuccess(): void
    {
        $endpoint = '/2.0/teams/gentle/hooks';
        $params = [
            'url' => 'http://requestb.in/xxx',
            'active' => true,
            'events' => [
                'repo:push',
                'issue:created',
            ],
        ];

        $this->hooks->create('gentle', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testUpdateSuccess(): void
    {
        $endpoint = '/2.0/teams/gentle/hooks/30b60aee-9cdf-407d-901c-2de106ee0c9d';
        $params = [
            'url' => 'http://requestb.in/zzz',
            'active' => true,
            'events' => [
                'repo:push',
                'issue:created',
            ],
        ];

        $this->hooks->update('gentle', '30b60aee-9cdf-407d-901c-2de106ee0c9d', $params);

        $this->assertRequest('PUT', $endpoint, json_encode($params));
    }

    /**
     * @dataProvider invalidCreateProvider
     */
    public function testInvalidUpdate(array $check): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hooks->update('gentle', '30b60aee-9cdf-407d-901c-2de106ee0c9d', $check);
    }

    public function testGetAllHooks(): void
    {
        $endpoint = '/2.0/teams/gentle/hooks';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->hooks->all('gentle');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetSingleHook(): void
    {
        $endpoint = '/2.0/teams/gentle/hooks/30b60aee-9cdf-407d-901c-2de106ee0c9d';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->hooks->get('gentle', '30b60aee-9cdf-407d-901c-2de106ee0c9d');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testDeleteSingleHook(): void
    {
        $endpoint = '/2.0/teams/gentle/hooks/30b60aee-9cdf-407d-901c-2de106ee0c9d';

        $this->hooks->delete('gentle', '30b60aee-9cdf-407d-901c-2de106ee0c9d');

        $this->assertRequest('DELETE', $endpoint);
    }
}
