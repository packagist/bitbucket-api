<?php

namespace Bitbucket\Tests\API\Repositories\PullRequests;

use Bitbucket\API\Repositories\PullRequests\Comments;
use Bitbucket\Tests\API\TestCase;

class CommentsTest extends TestCase
{
    /** @var Comments */
    private $comments;

    protected function setUp(): void
    {
        parent::setUp();
        $this->comments = $this->getApiMock(Comments::class);
    }

    public function testGetAllComments(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/3/comments';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->comments->all('gentle', 'eof', 3);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetSingleComment(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/3/comments/1';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->comments->get('gentle', 'eof', 3, 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreateCommentSuccess(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/comments';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->comments->create('gentle', 'eof', 1, 'test');

        $this->assertRequest('POST', $endpoint, json_encode(['content' => ['raw' => 'test']]));
        $this->assertResponse($expectedResult, $actual);
    }

    public function testUpdateCommentSuccess(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/comments/3';
        $expectedResult = $this->fakeResponse(['content' => 'dummy']);

        $actual = $this->comments->update('gentle', 'eof', 1, 3, 'dummy');

        $this->assertRequest('PUT', $endpoint, json_encode(['content' => ['raw' =>'dummy']]));
        $this->assertResponse($expectedResult, $actual);
    }

    public function testDeleteCommentSuccess(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/comments/2';

        $this->comments->delete('gentle', 'eof', 1, 2);

        $this->assertRequest('DELETE', $endpoint);
    }
}
