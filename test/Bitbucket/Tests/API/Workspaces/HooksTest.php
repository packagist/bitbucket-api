<?php

namespace Bitbucket\Tests\API\Workspaces;

use Bitbucket\API\Workspaces\Hooks;
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

    public function invalidCreateProvider()
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
    public function testInvalidCreate(array $check)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hooks->create('gentle', $check);
    }
}
