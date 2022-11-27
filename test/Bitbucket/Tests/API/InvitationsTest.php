<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Invitations;

class InvitationsTest extends TestCase
{
    /** @var Invitations */
    private $invitations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->invitations = $this->getApiMock(Invitations::class);
    }

    public function testSendInvitationSuccess(): void
    {
        $endpoint = '/1.0/invitations/gentle/eof';
        $params = http_build_query(['permission' => 'read', 'email' => 'john_doe@example.com']);

        $this->invitations->send('gentle', 'eof', 'john_doe@example.com', 'read');

        $this->assertRequest('POST', $endpoint, $params, 'format=json');
    }
}
