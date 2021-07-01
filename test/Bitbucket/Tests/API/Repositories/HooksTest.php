<?php

/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru Guzinschi <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\Hooks;
use Bitbucket\Tests\API\TestCase;
use Psr\Http\Message\ResponseInterface;

class HooksTest extends TestCase
{
    /** @var Hooks */
    private $hooks;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hooks = $this->getApiMock(Hooks::class);
    }

    public function invalidCreateProvider()
    {
        return [
            [[
                'dummy' => 'data',
            ]],
            [[
                'description' => 'My webhook',
                'url' => '',
                'active' => true,
            ]],
            [[
                'description' => 'My webhook',
                'url' => '',
                'active' => true,
                'events' => [],
            ]],
            [[
                'description' => 'My webhook',
                'url' => '',
                'events' => [
                    'event1',
                    'event2',
                ],
            ]],
            [[
                'description' => 'My webhook',
                'active' => true,
                'events' => [
                    'event1',
                    'event2',
                ],
                'extra' => 'Allow user to specify custom data',
            ]],
        ];
    }

    /**
     * @dataProvider invalidCreateProvider
     */
    public function testInvalidCreate(array $check)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hooks->create('gentle', 'my-repo', $check);
    }

    public function testCreateSuccess()
    {
        $endpoint = '/2.0/repositories/gentle/eof/hooks';
        $params = [
            'description' => 'My first webhook',
            'url' => 'http://requestb.in/xxx',
            'active' => true,
            'events' => [
                'repo:push',
                'issue:created',
            ],
        ];

        $this->hooks->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    /**
     * @ticket 72
     */
    public function testCreateIssue72()
    {
        $endpoint = '/2.0/repositories/gentle/eof/hooks';
        $params = [
            'description' => 'My first webhook',
            'url' => 'http://requestb.in/xxx',
            'active' => true,
            'events' => [
                'repo:push',
                'issue:created',
            ]
        ];

        $response = $this->hooks->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testCreateSuccessWithExtraParameters()
    {
        $endpoint = '/2.0/repositories/gentle/eof/hooks';
        $params = [
            'description' => 'My first webhook',
            'url' => 'http://requestb.in/xxx',
            'active' => true,
            'extra' => 'User can specify additional parameters',
            'events' => [
                'repo:push',
                'issue:created',
            ],
        ];

        $this->hooks->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testUpdateSuccess()
    {
        $endpoint = '/2.0/repositories/gentle/eof/hooks/30b60aee-9cdf-407d-901c-2de106ee0c9d';
        $params = [
            'description' => 'My first webhook',
            'url' => 'http://requestb.in/zzz',
            'active' => true,
            'events' => [
                'repo:push',
                'issue:created',
            ],
        ];

        $this->hooks->update('gentle', 'eof', '30b60aee-9cdf-407d-901c-2de106ee0c9d', $params);

        $this->assertRequest('PUT', $endpoint, json_encode($params));
    }

    /**
     * @dataProvider invalidCreateProvider
     */
    public function testInvalidUpdate(array $check)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hooks->update('gentle', 'eof', '30b60aee-9cdf-407d-901c-2de106ee0c9d', $check);
    }

    public function testGetAllHooks()
    {
        $endpoint = '/2.0/repositories/gentle/eof/hooks';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->hooks->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetSingleHook()
    {
        $endpoint = '/2.0/repositories/gentle/eof/hooks/30b60aee-9cdf-407d-901c-2de106ee0c9d';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->hooks->get('gentle', 'eof', '30b60aee-9cdf-407d-901c-2de106ee0c9d');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testDeleteSingleHook()
    {
        $endpoint = '/2.0/repositories/gentle/eof/hooks/30b60aee-9cdf-407d-901c-2de106ee0c9d';

        $this->hooks->delete('gentle', 'eof', '30b60aee-9cdf-407d-901c-2de106ee0c9d');

        $this->assertRequest('DELETE', $endpoint);
    }
}
