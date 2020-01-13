<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\Tests\API as Tests;

class UserTest extends Tests\TestCase
{
    public function testGetEmails()
    {
        $endpoint       = '/user/emails';
        $expectedResult = $this->fakeResponse(array('dummy'));

        $client = $this->getHttpClientMock();
        $client->expects($this->any())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var \Bitbucket\API\User $user */
        $user = $this->getClassMock('Bitbucket\API\User', $client);
        $actual = $user->emails();

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetUserProfileSuccess()
    {
        $endpoint       = '/user/';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->any())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var \Bitbucket\API\User $user */
        $user = $this->getClassMock('Bitbucket\API\User', $client);
        $actual = $user->get();

        $this->assertEquals($expectedResult, $actual);
    }
}
