<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\Pipelines;
use Bitbucket\Tests\API\TestCase;

class PipelinesTest extends TestCase
{
    /** @var Pipelines */
    private $pipelines;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pipelines = $this->getApiMock(Pipelines::class);
    }

    public function testGetAllPipelines(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pipelines/';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pipelines->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testCreatePipelinesFromArray(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pipelines/';
        $params = [
            'target' => [
                'ref_type' => 'branch',
                'type' => 'pipeline_ref_target',
                'ref_name' => 'master'
            ]
        ];

        $this->pipelines->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testCreatePipelinesFromJson(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pipelines/';
        $params = json_encode([
            'target' => [
                'ref_type' => 'branch',
                'type' => 'pipeline_ref_target',
                'ref_name' => 'master'
            ]
        ]);

        $this->pipelines->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, $params);
    }

    public function testGetSpecificPipeline(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pipelines/uuid';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->pipelines->get('gentle', 'eof', 'uuid');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testStopSpecificPipeline(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/pipelines/uuid/stopPipeline';

        $this->pipelines->stopPipeline('gentle', 'eof', 'uuid');

        $this->assertRequest('POST', $endpoint);
    }

    public function testGetSteps(): void
    {
        $this->assertInstanceOf(Pipelines\Steps::class, $this->pipelines->steps());
    }
}
