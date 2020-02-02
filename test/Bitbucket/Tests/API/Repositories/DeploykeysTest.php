<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\Deploykeys;
use Bitbucket\Tests\API\TestCase;

class DeploykeysTest extends TestCase
{
    /** @var Deploykeys */
    private $deploykeys;

    protected function setUp()
    {
        parent::setUp();
        $this->deploykeys = $this->getApiMock(Deploykeys::class);
    }

    public function testGetAllKeys()
    {
        $endpoint = '/2.0/repositories/gentle/eof/deploy-keys';
        $expectedResult = $this->fakeResponse('dummy');

        $actual = $this->deploykeys->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetSingleKey()
    {
        $endpoint = '/2.0/repositories/gentle/eof/deploy-keys/3';
        $expectedResult = $this->fakeResponse('dummy');

        $actual = $this->deploykeys->get('gentle', 'eof', 3);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testAddNewKeySuccess()
    {
        $endpoint = '/2.0/repositories/gentle/eof/deploy-keys';
        $params = [
            'key' => 'ssh-rsa [...]',
            'label' => 'dummy key'
        ];

        $this->deploykeys->create('gentle', 'eof', 'ssh-rsa [...]', 'dummy key');

        $this->assertRequest('POST', $endpoint, http_build_query($params));
    }

    public function testUpdateKeySuccess()
    {
        $endpoint = '/2.0/repositories/gentle/eof/deploy-keys/3';
        $params = ['label' => 'test key'];

        $this->deploykeys->update('gentle', 'eof', 3, $params);

        $this->assertRequest('PUT', $endpoint, http_build_query($params));
    }

    public function testDeleteKeySuccess()
    {
        $endpoint = '/2.0/repositories/gentle/eof/deploy-keys/3';

        $this->deploykeys->delete('gentle', 'eof', '3');

        $this->assertRequest('DELETE', $endpoint);
    }
}
