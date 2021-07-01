<?php

namespace Bitbucket\Tests\API\Repositories\Commits;

use Bitbucket\API\Repositories\Commits\Comments;
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

    public function testGetAllComments()
    {
        $endpoint = '/2.0/repositories/gentle/eof/commit/SHA1/comments';
        $expectedResult = $this->fakeResponse(array('dummy'));

        $actual = $this->comments->all('gentle', 'eof', 'SHA1');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetSingleComment()
    {
        $endpoint = '/2.0/repositories/gentle/eof/commit/SHA1/comments/1';
        $expectedResult = $this->fakeResponse(array('dummy'));

        $actual = $this->comments->get('gentle', 'eof', 'SHA1', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }
}
