<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\PullRequests;
use Bitbucket\Tests\API\TestCase;

class PullRequestsTest extends TestCase
{
    /** @var PullRequests */
    private $pullRequests;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pullRequests = $this->getApiMock(PullRequests::class);
    }

    public function testGetAllPullRequests(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint, '', 'state=OPEN');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreateNewPullRequestFromJSON(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests';
        $params = json_encode([
            'title' => 'Test PR',
            'source' => [
                'branch' => [
                    'name' => 'quickfix-1'
                ],
                'repository' => [
                    'full_name' => 'vimishor/secret-repo'
                ]
            ],
            'destination' => [
                'branch' => [
                    'name' => 'master'
                ]
            ]
        ]);

        $this->pullRequests->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, $params);
    }

    public function testCreateNewPullRequestFromArray(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests';
        $params = [
                'title'=> 'Test PR',
                'source' => [
                    'branch' => [
                        'name' => 'quickfix-1'
                    ],
                    'repository' => [
                        'full_name' => 'vimishor/secret-repo'
                    ]
                ],
                'destination' => [
                    'branch' => [
                        'name' => 'master'
                    ]
                ],
        ];

        $this->pullRequests->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    /**
     * @dataProvider pullRequestWrongParamsTypeProvider
     * @param string|int $params
     */
    public function testCreateNewPullRequestWithWrongParamsType($params): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->pullRequests->create('gentle', 'eof', $params);
    }

    public function pullRequestWrongParamsTypeProvider(): array
    {
        return [
            [''],
            [3],
            ["{ 'foo': 'bar' }"],
        ];
    }

    public function testUpdatePullRequestFromJSON(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1';
        $params = json_encode([
            'title' => 'Test PR (updated)',
            'destination' => [
                'branch' => [
                    'name' => 'master'
                ]
            ]
        ]);

        $this->pullRequests->update('gentle', 'eof', 1, $params);

        $this->assertRequest('PUT', $endpoint, $params);
    }

    public function testUpdatePullRequestFromArray(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1';
        $params = [
            'title' => 'Test PR (updated)',
            'destination' => [
                'branch' => [
                    'name' => 'master'
                ]
            ],
        ];

        $this->pullRequests->update('gentle', 'eof', 1, $params);

        $this->assertRequest('PUT', $endpoint, json_encode($params));
    }

    /**
     * @dataProvider pullRequestWrongParamsTypeProvider
     * @param string|int $params
     */
    public function testUpdatePullRequestWithWrongParamsType($params): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->pullRequests->update('gentle', 'eof', 1, $params);
    }

    public function testGetSpecificPullRequest(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->get('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetCommitsForSpecificPullRequest(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/commits';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->commits('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testApproveAPullRequest(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/approve';

        $this->pullRequests->approve('gentle', 'eof', 1);

        $this->assertRequest('POST', $endpoint);
    }

    public function testDeletePullRequestApproval(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/approve';

        $this->pullRequests->deleteApproval('gentle', 'eof', 1);

        $this->assertRequest('DELETE', $endpoint);
    }

    public function testGetPullRequestDiff(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/diff';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->diff('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetPullRequestDiffstat(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/diffstat';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->diffstat('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetPullRequestActivity(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/activity';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->activity('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetRepositoryPullRequestActivity(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/activity';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->activity('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testAcceptAndMergeAPullRequest(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/merge';
        $params = [
            'message'=> 'Lacks documentation.',
            'close_source_branch' => false
        ];

        $this->pullRequests->accept('gentle', 'eof', 1, $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testDeclineAPullRequest(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/decline';
        $params = [
            'message' => 'Please update the test suite.',
        ];

        $this->pullRequests->decline('gentle', 'eof', 1, $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    /**
     * @ticket 43
     */
    public function testDeclineAPullRequestWithoutAMessage(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/decline';
        $params = [
            'message' => ''
        ];

        $this->pullRequests->decline('gentle', 'eof', 1, []);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }
}
