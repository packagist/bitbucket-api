<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\Tests\API as Tests;

class MilestonesTest extends Tests\TestCase
{
    public function testGetAllMilestonesSuccess()
    {
        $endpoint       = 'repositories/gentle/eof/milestones';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $milestones \Bitbucket\API\Repositories\Milestones */
        $milestones = $this->getClassMock('Bitbucket\API\Repositories\Milestones', $client);
        $actual = $milestones->all('gentle', 'eof');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetSingleMilestoneSuccess()
    {
        $endpoint       = 'repositories/gentle/eof/milestones/2';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $milestone \Bitbucket\API\Repositories\Milestones */
        $milestones = $this->getClassMock('Bitbucket\API\Repositories\Milestones', $client);
        $actual = $milestones->get('gentle', 'eof', 2);

        $this->assertEquals($expectedResult, $actual);
    }
}
