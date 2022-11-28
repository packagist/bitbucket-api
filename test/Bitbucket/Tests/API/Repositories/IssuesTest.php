<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\Issues;
use Bitbucket\Tests\API\TestCase;

class IssuesTest extends TestCase
{
    /** @var Issues */
    private $issues;

    protected function setUp(): void
    {
        parent::setUp();
        $this->issues = $this->getApiMock(Issues::class);
    }

    public function testGetIssuesWithAdditionalParams(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/issues';
        $expectedResult = $this->fakeResponse(json_decode(file_get_contents(__DIR__.'/../data/issue/multiple.json'), true));
        $params = [
            'format'    => 'json',
            'limit'     => 5,
            'start'     => 0
        ];

        $actual = $this->issues->all('gentle', 'eof', $params);

        $this->assertRequest('GET', $endpoint, '', 'format=json&limit=5&start=0');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGet(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/issues/3';
        $expectedResult = $this->fakeResponse(json_decode(file_get_contents(__DIR__.'/../data/issue/single.json'), true));

        $actual = $this->issues->get('gentle', 'eof', 3);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreateIssue(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/issues';
        $params = [
            'title' => 'dummy title',
            'content' => ['raw' => 'dummy content'],
        ];

        $this->issues->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testShouldNotCreateIssueWithoutTitle(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $params = [
            'content' => ['raw' => 'dummy content'],
        ];

        $this->issues->create('gentle', 'eof', $params);
    }

    public function testShouldNotCreateIssueWithoutContent(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $params = [
            'title' => 'dummy title'
        ];

        $this->issues->create('gentle', 'eof', $params);
    }

    public function testUpdateIssue(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/issues/3';
        $params = [
            'title' => 'dummy title',
            'content' => ['raw' => 'dummy content'],
        ];

        $this->issues->update('gentle', 'eof', 3, $params);

        $this->assertRequest('PUT', $endpoint, json_encode($params));
    }


    public function testDeleteIssue(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/issues/2';
        $expectedResult = $this->fakeResponse(['dummyOutput']);

        $actual = $this->issues->delete('gentle', 'eof', 2);

        $this->assertRequest('DELETE', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetComments(): void
    {
        $this->assertInstanceOf(Issues\Comments::class, $this->issues->comments());
    }
}
