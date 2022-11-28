<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\Groups;
use Bitbucket\API\Groups\Members;

class GroupsTest extends TestCase
{
    /** @var Groups */
    private $groups;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groups = $this->getApiMock(Groups::class);
    }

    public function testGetAllGroups(): void
    {
        $endpoint = '/1.0/groups/gentle/';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->groups->get('gentle');

        $this->assertResponse($expectedResult, $actual);
        $this->assertRequest('GET', $endpoint, '', 'format=json');
    }

    public function testGetAllGroupsWithFilters(): void
    {
        $endpoint = '/1.0/groups';
        $query = 'group=gentle%2Ftesters%26group%3Dgentle%2Fmaintainers&format=json';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->groups->get('gentle', ['group' => ['gentle/testers', 'gentle/maintainers']]);

        $this->assertRequest('GET', $endpoint, '', $query);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreateGroupSuccess(): void
    {
        $endpoint = '/1.0/groups/gentle/';
        $params = http_build_query([
            'name'  => 'testers'
        ]);

        $this->groups->create('gentle', 'testers');

        $this->assertRequest('POST', $endpoint, $params, 'format=json');
    }

    public function testUpdateGroupSuccess(): void
    {
        $endpoint = '/1.0/groups/gentle/dummy/';
        $params = [
            'accountname' => 'gentle',
            'name' => 'Dummy group'
        ];

        $this->groups->update('gentle', 'dummy', $params);

        $this->assertRequest('PUT', $endpoint, http_build_query($params), 'format=json');
    }

    public function testDeleteGroupSuccess(): void
    {
        $endpoint = '/1.0/groups/gentle/dummy/';

        $this->groups->delete('gentle', 'dummy');

        $this->assertRequest('DELETE', $endpoint, '', 'format=json');
    }

    public function testGetMembers(): void
    {
        $this->assertInstanceOf(Members::class, $this->groups->members());
    }
}
