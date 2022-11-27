<?php

namespace Bitbucket\Tests\API\Users;

use Bitbucket\API\Users\SshKeys;
use Bitbucket\Tests\API as Tests;

class SshKeysTest extends Tests\TestCase
{
    /** @var SshKeys */
    private $sshKeys;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sshKeys = $this->getApiMock(SshKeys::class);
    }

    public function testGetAllSshKeys(): void
    {
        $endpoint = '/2.0/users/gentle/ssh-keys';
        $expectedResult = $this->fakeResponse([]);

        $actual = $this->sshKeys->all('gentle');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreateSshKey(): void
    {
        $endpoint = '/2.0/users/gentle/ssh-keys';
        $expectedResult = $this->fakeResponse([]);
        $params = [
            'key'   => 'key content',
            'label' => 'dummy key'
        ];

        $actual = $this->sshKeys->create('gentle', $params['key'], $params['label']);

        $this->assertRequest('POST', $endpoint, http_build_query($params));
        $this->assertResponse($expectedResult, $actual);
    }

    public function testUpdateSshKey(): void
    {
        $endpoint = '/2.0/users/gentle/ssh-keys/12';
        $expectedResult = $this->fakeResponse([]);
        $params = [
            'key'   => 'key content'
        ];

        $actual = $this->sshKeys->update('gentle', 12, $params['key']);

        $this->assertRequest('PUT', $endpoint, http_build_query($params));
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetSshKeyContent(): void
    {
        $endpoint = '/2.0/users/gentle/ssh-keys/2';
        $expectedResult = $this->fakeResponse([]);

        $actual = $this->sshKeys->get('gentle', 2);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testDeleteSshKey(): void
    {
        $endpoint = '/2.0/users/gentle/ssh-keys/2';
        $expectedResult = $this->fakeResponse([]);

        $actual = $this->sshKeys->delete('gentle', 2);

        $this->assertRequest('DELETE', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }
}
