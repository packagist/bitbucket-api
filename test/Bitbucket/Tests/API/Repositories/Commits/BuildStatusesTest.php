<?php

namespace Bitbucket\Tests\API\Repositories\Commits;

use Bitbucket\API\Repositories\Commits\BuildStatuses;
use Bitbucket\Tests\API\TestCase;

class BuildStatusesTest extends TestCase
{
    /** @var BuildStatuses */
    private $buildStatuses;

    protected function setUp()
    {
        parent::setUp();
        $this->buildStatuses = $this->getApiMock(BuildStatuses::class);
    }

    public function testGet()
    {
        $endpoint = '/2.0/repositories/gentle/eof/commit/SHA1/statuses/build/KEY';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->buildStatuses->get('gentle', 'eof', 'SHA1', 'KEY');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreate()
    {
        $endpoint = '/2.0/repositories/gentle/eof/commit/SHA1/statuses/build';
        $params = [
            'state' => 'SUCCESSFUL'
        ];

        $this->buildStatuses->create('gentle', 'eof', 'SHA1', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testUpdate()
    {
        $endpoint = '/2.0/repositories/gentle/eof/commit/SHA1/statuses/build/KEY';
        $params = [
            'state' => 'SUCCESSFUL'
        ];
        $this->buildStatuses->update('gentle', 'eof', 'SHA1', 'KEY', $params);

        $this->assertRequest('PUT', $endpoint, json_encode($params));
    }
}
