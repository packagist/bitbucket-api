<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\Tests\API as Tests;

class DeploykeysTest extends Tests\TestCase
{
    public function testGetAllKeys()
    {
        $endpoint       = '/repositories/gentle/eof/deploy-keys';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var \Bitbucket\API\Repositories\DeployKeys $dkey */
        $dkey = $this->getClassMock('Bitbucket\API\Repositories\DeployKeys', $client);
        $actual = $dkey->all('gentle', 'eof');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetSingleKey()
    {
        $endpoint       = '/repositories/gentle/eof/deploy-keys/3';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var \Bitbucket\API\Repositories\DeployKeys $dkey */
        $dkey = $this->getClassMock('Bitbucket\API\Repositories\DeployKeys', $client);
        $actual = $dkey->get('gentle', 'eof', 3);

        $this->assertEquals($expectedResult, $actual);
    }

    public function testAddNewKeySuccess()
    {
        $endpoint       = '/repositories/gentle/eof/deploy-keys';
        $params         = array(
            'key'   => 'ssh-rsa [...]',
            'label' => 'dummy key'
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('post')
            ->with($endpoint, $params)
            ->willReturn([]);

        /** @var \Bitbucket\API\Repositories\DeployKeys $dkey */
        $dkey = $this->getClassMock('Bitbucket\API\Repositories\DeployKeys', $client);
        $dkey->create('gentle', 'eof', 'ssh-rsa [...]', 'dummy key');
    }

    public function testUpdateKeySuccess()
    {
        $endpoint       = '/repositories/gentle/eof/deploy-keys/3';
        $params         = array('label' => 'test key');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('put')
            ->with($endpoint, $params)
            ->willReturn([]);

        /** @var \Bitbucket\API\Repositories\DeployKeys $dkey */
        $dkey = $this->getClassMock('Bitbucket\API\Repositories\DeployKeys', $client);
        $dkey->update('gentle', 'eof', 3, $params);
    }

    public function testDeleteKeySuccess()
    {
        $endpoint       = '/repositories/gentle/eof/deploy-keys/3';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('delete')
            ->with($endpoint)
            ->willReturn([]);

        /** @var \Bitbucket\API\Repositories\DeployKeys $dkey */
        $dkey = $this->getClassMock('Bitbucket\API\Repositories\DeployKeys', $client);
        $dkey->delete('gentle', 'eof', '3');
    }
}
