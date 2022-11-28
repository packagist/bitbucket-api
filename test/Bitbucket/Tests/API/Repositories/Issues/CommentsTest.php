<?php

namespace Bitbucket\Tests\API\Repositories\Issues;

use Bitbucket\API\Repositories\Issues\Comments;
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

    public function testGetSingleCommentSuccess(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/issues/3/comments/2967835';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->comments->get('gentle', 'eof', 3, 2967835);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetAllCommentsSuccess(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/issues/3/comments';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->comments->all('gentle', 'eof', 3);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreateCommentSuccess(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/issues/2/comments';
        $params = ['content' => ['raw' => 'dummy']];

        $this->comments->create('gentle', 'eof', 2, ['raw' => 'dummy']);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testUpdateCommentSuccess(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/issues/2/comments/3';
        $params = ['content' => ['raw' => 'dummy']];

        $this->comments->update('gentle', 'eof', 2, 3, ['raw' => 'dummy']);

        $this->assertRequest('PUT', $endpoint, json_encode($params));
    }
}
