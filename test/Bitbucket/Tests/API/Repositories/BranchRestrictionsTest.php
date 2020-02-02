<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\BranchRestrictions;
use Bitbucket\Tests\API\TestCase;

class BranchRestrictionsTest extends TestCase
{
    /** @var BranchRestrictions */
    private $branchRestrictions;

    protected function setUp()
    {
        parent::setUp();
        $this->branchRestrictions = $this->getApiMock(BranchRestrictions::class);
    }

    public function testGetAllRestrictions()
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->branchRestrictions->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testAddRestrictionType()
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions';
        $params = [
            'kind' => 'testpermission'
        ];

        $this->branchRestrictions->addAllowedRestrictionType(['testpermission']);
        $this->branchRestrictions->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testCreateRestrictionFromArray()
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions';
        $params = [
            'kind' => 'push'
        ];

        $this->branchRestrictions->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testCreateRestrictionFromJSON()
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions';
        $params = json_encode([
            'kind' => 'push'
        ]);

        $this->branchRestrictions->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, $params);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider restrictionsInvalidParamsProvider
     */
    public function testCreateRestrictionWithInvalidParams($params)
    {
        $this->branchRestrictions->create('gentle', 'eof', $params);
    }

    public function restrictionsInvalidParamsProvider()
    {
        return [
            [''],
            [3],
            ["{ 'foo': 'bar' }"]
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateRestrictionFromArrayShouldFailWithInvalidRestrictionKind()
    {
        $params = [
            'kind' => 'invalid'
        ];

        $this->branchRestrictions->create('gentle', 'eof', $params);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateRestrictionFromJSONShouldFailWithInvalidRestrictionKind()
    {
        $params = json_encode([
            'kind' => 'invalid'
        ]);

        $this->branchRestrictions->create('gentle', 'eof', $params);
    }

    public function testGetSpecificRestriction()
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions/1';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->branchRestrictions->get('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testUpdateRestrictionFromArray()
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions/1';
        $params = [
            'users' => [
                ['username' => 'vimishor'],
                ['username' => 'gtl_test1']
            ]
        ];

        $this->branchRestrictions->update('gentle', 'eof', 1, $params);

        $this->assertRequest('PUT', $endpoint, json_encode($params));
    }

    public function testUpdateRestrictionFromJSON()
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions/1';
        $params = json_encode([
            'dummy' => [
                ['username' => 'vimishor'],
                ['username' => 'gtl_test1']
            ]
        ]);

        $this->branchRestrictions->update('gentle', 'eof', 1, $params);

        $this->assertRequest('PUT', $endpoint, $params);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider restrictionsInvalidParamsProvider
     */
    public function testUpdateRestrictionWithInvalidParams($params)
    {
        $this->branchRestrictions->update('gentle', 'eof', 1, $params);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateRestrictionShouldFailIfKindIsSpecified()
    {
        $params = [
            'kind' => 'invalid'
        ];

        $this->branchRestrictions->update('gentle', 'eof', 1, $params);
    }

    public function testDeleteRestriction()
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions/1';

        $this->branchRestrictions->delete('gentle', 'eof', 1);

        $this->assertRequest('DELETE', $endpoint);
    }
}
