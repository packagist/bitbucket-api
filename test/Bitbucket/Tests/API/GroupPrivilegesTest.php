<?php

namespace Bitbucket\Tests\API;

use Bitbucket\Tests\API as Tests;

class GroupPrivilegesTest extends Tests\TestCase
{
    public function testGetGroupsPrivilegesSuccess()
    {
        $endpoint       = '/group-privileges/gentle/';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint);

        /** @var $privileges \Bitbucket\API\GroupPrivileges */
        $privileges = $this->getClassMock('Bitbucket\API\GroupPrivileges', $client);
        $privileges->groups('gentle');
    }

    public function testGetRepositoryPrivilegesSuccess()
    {
        $endpoint       = '/group-privileges/gentle/dummy-repo';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint);

        /** @var $privileges \Bitbucket\API\GroupPrivileges */
        $privileges = $this->getClassMock('Bitbucket\API\GroupPrivileges', $client);
        $privileges->repository('gentle', 'dummy-repo');
    }

    public function testGetGroupPrivilegesSuccess()
    {
        $endpoint       = '/group-privileges/gentle/dummy-repo/owner/testers';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint);

        /** @var $privileges \Bitbucket\API\GroupPrivileges */
        $privileges = $this->getClassMock('Bitbucket\API\GroupPrivileges', $client);
        $privileges->group('gentle', 'dummy-repo', 'owner', 'testers');
    }

    public function testGetRepositoriesPrivilegeGroupSuccess()
    {
        $endpoint       = '/group-privileges/gentle/owner/testers';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint);

        /** @var $privileges \Bitbucket\API\GroupPrivileges */
        $privileges = $this->getClassMock('Bitbucket\API\GroupPrivileges', $client);
        $privileges->repositories('gentle', 'owner', 'testers');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGrantGroupPrivilegesInvalidPrivilege()
    {
        $client = $this->getHttpClientMock();

        /** @var $privileges \Bitbucket\API\GroupPrivileges */
        $privileges = $this->getClassMock('Bitbucket\API\GroupPrivileges', $client);
        $privileges->grant('gentle', 'repo', 'owner', 'sys-admins', 'invalid');
    }

    public function testGrantGroupPrivilegesSuccess()
    {
        $endpoint       = '/group-privileges/gentle/repo/owner/sys-admins';
        $params         = 'read';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('put')
            ->with($endpoint, $params);

        /** @var $privileges \Bitbucket\API\GroupPrivileges */
        $privileges = $this->getClassMock('Bitbucket\API\GroupPrivileges', $client);
        $privileges->grant('gentle', 'repo', 'owner', 'sys-admins', 'read');
    }

    public function testRemoveGroupPrivilegesFromRepositorySuccess()
    {
        $endpoint       = '/group-privileges/gentle/repo/owner/sys-admins';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('delete')
            ->with($endpoint);

        /** @var $privileges \Bitbucket\API\GroupPrivileges */
        $privileges = $this->getClassMock('Bitbucket\API\GroupPrivileges', $client);
        $privileges->delete('gentle', 'repo', 'owner', 'sys-admins');
    }
}
