<?php

namespace Bitbucket\Tests\API\Users;

use Bitbucket\Tests\API as Tests;

class SshKeysTest extends Tests\TestCase
{
    public function testGetAllSshKeys()
    {
        $endpoint       = '/users/gentle/ssh-keys';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $keys \Bitbucket\API\Users\SshKeys */
        $keys = $this->getClassMock('Bitbucket\API\Users\SshKeys', $client);
        $actual = $keys->all('gentle');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testCreateSshKey()
    {
        $endpoint       = '/users/gentle/ssh-keys';
        $expectedResult = json_encode('dummy');
        $params         = array(
            'key'   => 'key content',
            'label' => 'dummy key'
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('post')
            ->with($endpoint, $params)
            ->willReturn($expectedResult);

        /** @var $keys \Bitbucket\API\Users\SshKeys */
        $keys = $this->getClassMock('Bitbucket\API\Users\SshKeys', $client);
        $actual = $keys->create('gentle', $params['key'], $params['label']);

        $this->assertEquals($expectedResult, $actual);
    }

    public function testUpdateSshKey()
    {
        $endpoint       = '/users/gentle/ssh-keys/12';
        $expectedResult = json_encode('dummy');
        $params         = array(
            'key'   => 'key content'
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('put')
            ->with($endpoint, $params)
            ->willReturn($expectedResult);

        /** @var $keys \Bitbucket\API\Users\SshKeys */
        $keys = $this->getClassMock('Bitbucket\API\Users\SshKeys', $client);
        $actual = $keys->update('gentle', 12, $params['key']);

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetSshKeyContent()
    {
        $endpoint       = '/users/gentle/ssh-keys/2';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $keys \Bitbucket\API\Users\SshKeys */
        $keys = $this->getClassMock('Bitbucket\API\Users\SshKeys', $client);
        $actual = $keys->get('gentle', 2);

        $this->assertEquals($expectedResult, $actual);
    }

    public function testDeleteSshKey()
    {
        $endpoint       = '/users/gentle/ssh-keys/2';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('delete')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $keys \Bitbucket\API\Users\SshKeys */
        $keys = $this->getClassMock('Bitbucket\API\Users\SshKeys', $client);
        $actual = $keys->delete('gentle', 2);

        $this->assertEquals($expectedResult, $actual);
    }
}
