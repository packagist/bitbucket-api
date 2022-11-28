<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\Commits;
use Bitbucket\Tests\API\TestCase;

class CommitsTest extends TestCase
{
    /** @var Commits */
    private $commits;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commits = $this->getApiMock(Commits::class);
    }

    public function testGetAllRepositoryCommits(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/commits';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->commits->all('gentle', 'eof', ['dummy']);

        $this->assertRequest('GET', $endpoint, '', '0=dummy');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetAllRepositoryCommitsFromSpecificBranch(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/commits/master';
        $expectedResult = $this->fakeResponse(['dummy', 'branch' => 'master']);

        $actual = $this->commits->all('gentle', 'eof', ['dummy', 'branch' => 'master']);

        $this->assertRequest('GET', $endpoint, '', '0=dummy');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetSingleCommitInfo(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/commit/SHA';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->commits->get('gentle', 'eof', 'SHA');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testApproveACommit(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/commit/SHA1/approve';

        $this->commits->approve('gentle', 'eof', 'SHA1');

        $this->assertRequest('POST', $endpoint);
    }

    public function testDeleteCommitApproval(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/commit/SHA1/approve';

        $this->commits->deleteApproval('gentle', 'eof', 'SHA1');

        $this->assertRequest('DELETE', $endpoint);
    }

    public function testGetMembers(): void
    {
        $this->assertInstanceOf(Commits\Comments::class, $this->commits->comments());
    }
}
