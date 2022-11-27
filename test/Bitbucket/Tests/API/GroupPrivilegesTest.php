<?php

namespace Bitbucket\Tests\API;

use Bitbucket\API\GroupPrivileges;

class GroupPrivilegesTest extends TestCase
{
    /** @var GroupPrivileges */
    private $groupPrivileges;

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupPrivileges = $this->getApiMock(GroupPrivileges::class);
    }

    public function testGetGroupsPrivilegesSuccess(): void
    {
        $endpoint = '/1.0/group-privileges/gentle/';

        $this->groupPrivileges->groups('gentle');

        $this->assertRequest('GET', $endpoint, '', 'format=json');
    }

    public function testGetRepositoryPrivilegesSuccess(): void
    {
        $endpoint = '/1.0/group-privileges/gentle/dummy-repo';

        $this->groupPrivileges->repository('gentle', 'dummy-repo');

        $this->assertRequest('GET', $endpoint, '', 'format=json');
    }

    public function testGetGroupPrivilegesSuccess(): void
    {
        $endpoint = '/1.0/group-privileges/gentle/dummy-repo/owner/testers';

        $this->groupPrivileges->group('gentle', 'dummy-repo', 'owner', 'testers');

        $this->assertRequest('GET', $endpoint, '', 'format=json');
    }

    public function testGetRepositoriesPrivilegeGroupSuccess(): void
    {
        $endpoint = '/1.0/group-privileges/gentle/owner/testers';

        $this->groupPrivileges->repositories('gentle', 'owner', 'testers');

        $this->assertRequest('GET', $endpoint, '', 'format=json');
    }

    public function testGrantGroupPrivilegesInvalidPrivilege(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->groupPrivileges->grant('gentle', 'repo', 'owner', 'sys-admins', 'invalid');
    }

    public function testGrantGroupPrivilegesSuccess(): void
    {
        $endpoint = '/1.0/group-privileges/gentle/repo/owner/sys-admins';
        $params = 'read';

        $this->groupPrivileges->grant('gentle', 'repo', 'owner', 'sys-admins', 'read');

        $this->assertRequest('PUT', $endpoint, $params, 'format=json');
    }

    public function testRemoveGroupPrivilegesFromRepositorySuccess(): void
    {
        $endpoint = '/1.0/group-privileges/gentle/repo/owner/sys-admins';

        $this->groupPrivileges->delete('gentle', 'repo', 'owner', 'sys-admins');

        $this->assertRequest('DELETE', $endpoint, '', 'format=json');
    }
}
