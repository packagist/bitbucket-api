<?php

namespace Bitbucket\Tests\API\Workspaces;

use Bitbucket\API\Workspaces\Hooks;
use Bitbucket\Tests\API\TestCase;

class HooksTest extends TestCase
{
    /** @var Hooks */
    private $hooks;

    protected function setUp()
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
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidCreateProvider
     */
    public function testInvalidCreate(array $check)
    {
        $this->hooks->create('gentle', $check);
    }
}
