<?php

namespace Bitbucket\Tests\API\Repositories\Pipelines;

use Bitbucket\API\Repositories\Pipelines\Steps;
use Bitbucket\Tests\API\TestCase;

class StepsTest extends TestCase
{
    /** @var Steps */
    private $steps;

    protected function setUp()
    {
        parent::setUp();
        $this->steps = $this->getApiMock(Steps::class);
    }

    public function testGetAllSteps()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pipelines/pipeline-uuid/steps/';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->steps->all('gentle', 'eof', 'pipeline-uuid');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetSpecificPipelineStep()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pipelines/pipeline-uuid/steps/step-uuid';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->steps->get('gentle', 'eof', 'pipeline-uuid', 'step-uuid');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetLogOfSpecificPipelineStep()
    {
        $endpoint = '/2.0/repositories/gentle/eof/pipelines/pipeline-uuid/steps/step-uuid/log';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->steps->log('gentle', 'eof', 'pipeline-uuid', 'step-uuid');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }
}
