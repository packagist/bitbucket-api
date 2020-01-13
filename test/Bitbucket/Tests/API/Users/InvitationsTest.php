<?php

namespace Bitbucket\Tests\API\Users;

use Bitbucket\Tests\API as Tests;

class InvitationsTest extends Tests\TestCase
{
    public function testGetAllInvitations()
    {
        $endpoint       = '/users/gentle/invitations';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $invitations \Bitbucket\API\Users\Invitations */
        $invitations = $this->getClassMock('Bitbucket\API\Users\Invitations', $client);
        $actual = $invitations->all('gentle');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testIssuesNewInvitationSuccess()
    {
        $endpoint       = '/users/gentle/invitations';
        $expectedResult = json_encode('dummy');
        $params         = ['email' => 'dummy@example.com', 'group_slug' => 'testers'];

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('put')
            ->with($endpoint, $params)
            ->willReturn($expectedResult);

        /** @var $invitations \Bitbucket\API\Users\Invitations */
        $invitations = $this->getClassMock('Bitbucket\API\Users\Invitations', $client);
        $actual = $invitations->create('gentle', 'testers', 'dummy@example.com');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testDeleteInvitationByEmailSuccess()
    {
        $endpoint       = '/users/gentle/invitations';
        $expectedResult = json_encode('dummy');
        $params         = ['email' => 'dummy@example.com'];

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('delete')
            ->with($endpoint, $params)
            ->willReturn($expectedResult);

        /** @var $invitations \Bitbucket\API\Users\Invitations */
        $invitations = $this->getClassMock('Bitbucket\API\Users\Invitations', $client);
        $actual = $invitations->deleteByEmail('gentle', 'dummy@example.com');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testDeleteInvitationByGroupSuccess()
    {
        $endpoint       = '/users/gentle/invitations';
        $expectedResult = json_encode('dummy');
        $params         = ['email' => 'dummy@example.com', 'group_slug' => 'testers'];

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('delete')
            ->with($endpoint, $params)
            ->willReturn($expectedResult);

        /** @var $invitations \Bitbucket\API\Users\Invitations */
        $invitations = $this->getClassMock('Bitbucket\API\Users\Invitations', $client);
        $actual = $invitations->deleteByGroup('gentle', 'testers', 'dummy@example.com');

        $this->assertEquals($expectedResult, $actual);
    }
}
