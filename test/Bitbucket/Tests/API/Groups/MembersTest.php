<?php

namespace Bitbucket\Tests\API\Groups;

use Bitbucket\API\Groups\Members;
use Bitbucket\Tests\API\TestCase;

class MembersTest extends TestCase
{
    /** @var Members */
    private $members;

    protected function setUp()
    {
        parent::setUp();
        $this->members = $this->getApiMock(Members::class);
    }

    public function testGetAllGroupMembers()
    {
        $endpoint = '/1.0/groups/gentle/testers/members';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->members->all('gentle', 'testers');

        $this->assertRequest('GET', $endpoint, '', 'format=json');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testAddMemberToGroupSuccess()
    {
        $endpoint = '/1.0/groups/gentle/testers/members/steve';

        $this->members->add('gentle', 'testers', 'steve');

        $this->assertRequest('PUT', $endpoint, '', 'format=json');
    }

    public function testDeleteMemberFromGroupSuccess()
    {
        $endpoint = '/1.0/groups/gentle/testers/members/steve';

        $this->members->delete('gentle', 'testers', 'steve');

        $this->assertRequest('DELETE', $endpoint, '', 'format=json');
    }
}
