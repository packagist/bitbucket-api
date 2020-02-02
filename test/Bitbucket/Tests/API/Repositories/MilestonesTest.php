<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\Milestones;
use Bitbucket\Tests\API\TestCase;

class MilestonesTest extends TestCase
{
    /** @var Milestones */
    private $milestones;

    protected function setUp()
    {
        parent::setUp();
        $this->milestones = $this->getApiMock(Milestones::class);
    }

    public function testGetAllMilestonesSuccess()
    {
        $endpoint = '/2.0/repositories/gentle/eof/milestones';
        $expectedResult = $this->fakeResponse('dummy');

        $actual = $this->milestones->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetSingleMilestoneSuccess()
    {
        $endpoint = '/2.0/repositories/gentle/eof/milestones/2';
        $expectedResult = $this->fakeResponse('dummy');

        $actual = $this->milestones->get('gentle', 'eof', 2);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }
}
