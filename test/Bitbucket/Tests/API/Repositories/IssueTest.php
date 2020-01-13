<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\Tests\API as Tests;
use Bitbucket\API;

class IssueTest extends Tests\TestCase
{
    public function testGetIssuesWithAdditionalParams()
    {
        $endpoint       = '/repositories/gentle/eof/issues';
        $expectedResult = file_get_contents(__DIR__.'/../data/issue/multiple.json');
        $params         = array(
            'format'    => 'json',
            'limit'     => 5,
            'start'     => 0
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint, $params)
            ->willReturn($expectedResult);

        /** @var $issue \Bitbucket\API\Repositories\Issues */
        $issue = $this->getClassMock('Bitbucket\API\Repositories\Issues', $client);
        $actual = $issue->all('gentle', 'eof', $params);

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGet()
    {
        $endpoint       = '/repositories/gentle/eof/issues/3';
        $expectedResult = file_get_contents(__DIR__.'/../data/issue/single.json');
        $params         = array();

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint, $params)
            ->willReturn($expectedResult);

        /** @var $issue \Bitbucket\API\Repositories\Issues */
        $issue = $this->getClassMock('Bitbucket\API\Repositories\Issues', $client);
        $actual = $issue->get('gentle', 'eof', 3);

        $this->assertEquals($expectedResult, $actual);
    }

    public function testCreateIssue()
    {
        $endpoint       = '/repositories/gentle/eof/issues';
        $params         = array(
            'format'    => 'json',
            'title'     => 'dummy title',
            'content'   => 'dummy content'
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('post')
            ->with($endpoint, $params);

        /** @var $issue \Bitbucket\API\Repositories\Issues */
        $issue = $this->getClassMock('Bitbucket\API\Repositories\Issues', $client);
        $issue->create('gentle', 'eof', $params);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldNotCreateIssueWithoutTitle()
    {
        $params         = array(
            'format'    => 'json',
            'content'   => 'dummy content'
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->never())
            ->method('post');

        /** @var $issue \Bitbucket\API\Repositories\Issues */
        $issue = $this->getClassMock('Bitbucket\API\Repositories\Issues', $client);
        $issue->create('gentle', 'eof', $params);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShouldNotCreateIssueWithoutContent()
    {
        $params         = array(
            'format'    => 'json',
            'title'     => 'dummy title'
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->never())
            ->method('post');

        /** @var $issue \Bitbucket\API\Repositories\Issues */
        $issue = $this->getClassMock('Bitbucket\API\Repositories\Issues', $client);
        $issue->create('gentle', 'eof', $params);
    }

    public function testUpdateIssue()
    {
        $endpoint       = '/repositories/gentle/eof/issues/3';
        $params         = array(
            'format'    => 'json',
            'title'     => 'dummy title',
            'content'   => 'dummy content'
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('put')
            ->with($endpoint, $params);

        /** @var $issue \Bitbucket\API\Repositories\Issues */
        $issue = $this->getClassMock('Bitbucket\API\Repositories\Issues', $client);
        $issue->update('gentle', 'eof', 3, $params);
    }


    public function testDeleteIssue()
    {
        $endpoint       = '/repositories/gentle/eof/issues/2';
        $expectedResult = array('dummyOutput');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('delete')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $issue \Bitbucket\API\Repositories\Issues */
        $issue = $this->getClassMock('Bitbucket\API\Repositories\Issues', $client);
        $actual = $issue->delete('gentle', 'eof', 2);

        $this->assertEquals($expectedResult, $actual);
    }
}
