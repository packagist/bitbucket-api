<?php

namespace Bitbucket\Tests\API\Users;

use Bitbucket\Tests\API as Tests;
use Bitbucket\API;

class AccountTest extends Tests\TestCase
{
    public function testGetAccountProfile()
    {
        $endpoint       = 'users/gentle';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $account \Bitbucket\API\Users\Account */
        $account = $this->getClassMock('Bitbucket\API\Users\Account', $client);
        $actual = $account->profile('gentle');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetAccountFollowers()
    {
        $endpoint       = 'users/gentle/followers';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $account \Bitbucket\API\Users\Account */
        $account = $this->getClassMock('Bitbucket\API\Users\Account', $client);
        $actual = $account->followers('gentle');

        $this->assertEquals($expectedResult, $actual);
    }
}
