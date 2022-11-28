<?php

namespace Bitbucket\Tests\API\Users;

use Bitbucket\API\Users\Invitations;
use Bitbucket\Tests\API as Tests;

class InvitationsTest extends Tests\TestCase
{
    /** @var Invitations */
    private $invitations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->invitations = $this->getApiMock(Invitations::class);
    }

    public function testGetAllInvitations(): void
    {
        $endpoint = '/1.0/users/gentle/invitations';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->invitations->all('gentle');

        $this->assertRequest('GET', $endpoint, '', 'format=json');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testIssuesNewInvitationSuccess(): void
    {
        $endpoint = '/1.0/users/gentle/invitations';
        $expectedResult = $this->fakeResponse(['dummy']);
        $params = ['email' => 'dummy@example.com', 'group_slug' => 'testers'];

        $actual = $this->invitations->create('gentle', 'testers', 'dummy@example.com');

        $this->assertRequest('PUT', $endpoint, http_build_query($params), 'format=json');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testDeleteInvitationByEmailSuccess(): void
    {
        $endpoint = '/1.0/users/gentle/invitations';
        $expectedResult = $this->fakeResponse(['dummy']);
        $params = ['email' => 'dummy@example.com'];

        $actual = $this->invitations->deleteByEmail('gentle', 'dummy@example.com');

        $this->assertRequest('DELETE', $endpoint, http_build_query($params), 'format=json');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testDeleteInvitationByGroupSuccess(): void
    {
        $endpoint = '/1.0/users/gentle/invitations';
        $expectedResult = $this->fakeResponse(['dummy']);
        $params = ['email' => 'dummy@example.com', 'group_slug' => 'testers'];

        $actual = $this->invitations->deleteByGroup('gentle', 'testers', 'dummy@example.com');

        $this->assertRequest('DELETE', $endpoint, http_build_query($params), 'format=json');
        $this->assertResponse($expectedResult, $actual);
    }
}
