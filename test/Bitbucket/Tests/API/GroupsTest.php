<?php

namespace Bitbucket\Tests\API;

use Bitbucket\Tests\API as Tests;

class GroupsTest extends Tests\TestCase
{
    public function testGetAllGroups()
    {
        $endpoint       = '/groups/gentle/';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $groups \Bitbucket\API\Groups */
        $groups = $this->getClassMock('Bitbucket\API\Groups', $client);
        $actual = $groups->get('gentle');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetAllGroupsWithFilters()
    {
        $endpoint       = '/groups';
        $params         = array('group' => 'gentle/testers&group=gentle/maintainers');
        $expectedResult = 'x';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint, $params)
            ->willReturn($expectedResult);

        /** @var $groups \Bitbucket\API\Groups */
        $groups = $this->getClassMock('Bitbucket\API\Groups', $client);
        $actual = $groups->get('gentle', array('group' => array('gentle/testers', 'gentle/maintainers')));

        $this->assertEquals($expectedResult, $actual);
    }

    public function testCreateGroupSuccess()
    {
        $endpoint       = '/groups/gentle/';
        $params         = array(
            'name'  => 'testers'
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('post')
            ->with($endpoint, $params);

        /** @var $groups \Bitbucket\API\Groups */
        $groups = $this->getClassMock('Bitbucket\API\Groups', $client);
        $groups->create('gentle', 'testers');
    }

    public function testUpdateGroupSuccess()
    {
        $endpoint       = '/groups/gentle/dummy/';
        $params         = array(
            'accountname'   => 'gentle',
            'name'          => 'Dummy group'
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('put')
            ->with($endpoint, $params);

        /** @var $group \Bitbucket\API\Groups */
        $group = $this->getClassMock('Bitbucket\API\Groups', $client);
        $group->update('gentle', 'dummy', $params);
    }

    public function testDeleteGroupSuccess()
    {
        $endpoint       = '/groups/gentle/dummy/';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('delete')
            ->with($endpoint);

        /** @var $groups \Bitbucket\API\Groups */
        $groups = $this->getClassMock('Bitbucket\API\Groups', $client);
        $groups->delete('gentle', 'dummy');
    }
}
