<?php

namespace Bitbucket\Tests\API;

use Bitbucket\Tests\API as Tests;

class InvitationsTest extends Tests\TestCase
{
    public function testSendInvitationSuccess()
    {
        $endpoint       = 'invitations/gentle/eof';
        $params         = array('email' => 'john_doe@example.com', 'permission' => 'read');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('post')
            ->with($endpoint, $params);

        /** @var $invitation \Bitbucket\API\Invitations */
        $invitation = $this->getClassMock('Bitbucket\API\Invitations', $client);
        $invitation->send('gentle', 'eof', 'john_doe@example.com', 'read');
    }
}
