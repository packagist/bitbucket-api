<?php

namespace Bitbucket\Tests\API\Groups;

use Bitbucket\Tests\API as Tests;

class MembersTest extends Tests\TestCase
{
    public function testGetAllGroupMembers()
    {
        $endpoint       = '/groups/gentle/testers/members';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $members \Bitbucket\API\Groups\Members */
        $members = $this->getClassMock('Bitbucket\API\Groups\Members', $client);
        $actual = $members->all('gentle', 'testers');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testAddMemberToGroupSuccess()
    {
        $endpoint       = '/groups/gentle/testers/members/steve';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('put')
            ->with($endpoint);

        /** @var $member \Bitbucket\API\Groups\Members */
        $member = $this->getClassMock('Bitbucket\API\Groups\Members', $client);
        $member->add('gentle', 'testers', 'steve');
    }

    public function testDeleteMemberFromGroupSuccess()
    {
        $endpoint       = '/groups/gentle/testers/members/steve';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('delete')
            ->with($endpoint);

        /** @var $member \Bitbucket\API\Groups\Members */
        $member = $this->getClassMock('Bitbucket\API\Groups\Members', $client);
        $member->delete('gentle', 'testers', 'steve');
    }
}
