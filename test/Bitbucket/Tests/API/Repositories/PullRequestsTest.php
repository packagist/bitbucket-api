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

    public function testGetAllPullRequests()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint, '', 'state=OPEN');
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreateNewPullRequestFromJSON()
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

    public function testCreateNewPullRequestFromArray()
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
     */
    public function testCreateNewPullRequestWithWrongParamsType($params)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->pullRequests->create('gentle', 'eof', $params);
    }

    public function pullRequestWrongParamsTypeProvider()
    {
        return [
            [''],
            [3],
            ["{ 'foo': 'bar' }"],
        ];
    }

    public function testUpdatePullRequestFromJSON()
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

    public function testUpdatePullRequestFromArray()
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
     */
    public function testUpdatePullRequestWithWrongParamsType($params)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->pullRequests->update('gentle', 'eof', 1, $params);
    }

    public function testGetSpecificPullRequest()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->get('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetCommitsForSpecificPullRequest()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/commits';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->commits('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testApproveAPullRequest()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/approve';

        $this->pullRequests->approve('gentle', 'eof', 1);

        $this->assertRequest('POST', $endpoint);
    }

    public function testDeletePullRequestApproval()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/approve';

        $this->pullRequests->deleteApproval('gentle', 'eof', 1);

        $this->assertRequest('DELETE', $endpoint);
    }

    public function testGetPullRequestDiff()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/diff';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->diff('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetPullRequestDiffstat()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/diffstat';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->diffstat('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetPullRequestActivity()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/activity';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->activity('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetRepositoryPullRequestActivity()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/activity';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pullRequests->activity('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testAcceptAndMergeAPullRequest()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/merge';
        $params = [
            'message'=> 'Lacks documentation.',
            'close_source_branch' => false
        ];

        $this->pullRequests->accept('gentle', 'eof', 1, $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testDeclineAPullRequest()
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
    public function testDeclineAPullRequestWithoutAMessage()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pullrequests/1/decline';
        $params = [
            'message' => ''
        ];

        $this->pullRequests->decline('gentle', 'eof', 1, []);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }
}
