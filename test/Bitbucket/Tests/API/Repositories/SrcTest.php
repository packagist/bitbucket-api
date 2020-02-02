<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\Src;
use Bitbucket\Tests\API\TestCase;

class SrcTest extends TestCase
{
    /** @var Src */
    private $src;

    protected function setUp()
    {
        parent::setUp();
        $this->src = $this->getApiMock(Src::class);
    }

    public function testListRepoSrc()
    {
        $endpoint = '/2.0/repositories/gentle/eof/src/1e10ffe//lib';
        $expectedResult = $this->fakeResponse(json_encode(['dummy']));

        $actual = $this->src->get('gentle', 'eof', '1e10ffe', '/lib');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testSrcGetRawContent()
    {
        $endpoint = '/2.0/repositories/gentle/eof/src/1e10ffe/lib/Gentle/Bitbucket/API/Repositories/Services.php';
        $expectedResult = $this->fakeResponse(json_encode(['dummy']));

        $actual = $this->src->get('gentle', 'eof', '1e10ffe', 'lib/Gentle/Bitbucket/API/Repositories/Services.php');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider srcInvalidParamsProvider
     */
    public function testSrcCreateWithInvalidParams($params)
    {
        $this->src->create('gentle', 'eof', $params);
    }

    public function srcInvalidParamsProvider()
    {
        return [
            [[]],
            [[3]]
        ];
    }

    public function testSrcCreateFile()
    {
        $endpoint = '/2.0/repositories/gentle/eof/src';
        $params = [
            '/testfile' => 'dummy',
            'author' => 'Gentle <noreply@gentle.com>',
            'message' => 'Test commit'
        ];

        $this->src->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, http_build_query($params));
    }

    public function testSrcCreateBranch()
    {
        $endpoint = '/2.0/repositories/gentle/eof/src';
        $params = [
            'branch' => 'new-branch',
            'author' => 'Gentle <noreply@gentle.com>',
            'message' => 'Test create branch'
        ];

        $this->src->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, http_build_query($params));
    }
}
