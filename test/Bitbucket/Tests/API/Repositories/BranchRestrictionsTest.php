<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\BranchRestrictions;
use Bitbucket\Tests\API\TestCase;

class BranchRestrictionsTest extends TestCase
{
    /** @var BranchRestrictions */
    private $branchRestrictions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->branchRestrictions = $this->getApiMock(BranchRestrictions::class);
    }

    public function testGetAllRestrictions(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->branchRestrictions->all('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testAddRestrictionType(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions';
        $params = [
            'kind' => 'testpermission'
        ];

        $this->branchRestrictions->addAllowedRestrictionType(['testpermission']);
        $this->branchRestrictions->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testCreateRestrictionFromArray(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions';
        $params = [
            'kind' => 'push'
        ];

        $this->branchRestrictions->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testCreateRestrictionFromJSON(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions';
        $params = json_encode([
            'kind' => 'push'
        ]);

        $this->branchRestrictions->create('gentle', 'eof', $params);

        $this->assertRequest('POST', $endpoint, $params);
    }

    /**
     * @dataProvider restrictionsInvalidParamsProvider
     * @param int|string $params
     */
    public function testCreateRestrictionWithInvalidParams($params): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->branchRestrictions->create('gentle', 'eof', $params);
    }

    public function restrictionsInvalidParamsProvider(): array
    {
        return [
            [''],
            [3],
            ["{ 'foo': 'bar' }"]
        ];
    }

    public function testCreateRestrictionFromArrayShouldFailWithInvalidRestrictionKind(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $params = [
            'kind' => 'invalid'
        ];

        $this->branchRestrictions->create('gentle', 'eof', $params);
    }

    public function testCreateRestrictionFromJSONShouldFailWithInvalidRestrictionKind(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $params = json_encode([
            'kind' => 'invalid'
        ]);

        $this->branchRestrictions->create('gentle', 'eof', $params);
    }

    public function testGetSpecificRestriction(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions/1';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->branchRestrictions->get('gentle', 'eof', 1);

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testUpdateRestrictionFromArray(): void
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

    public function testUpdateRestrictionFromJSON(): void
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
     * @dataProvider restrictionsInvalidParamsProvider
     * @param int|string $params
     */
    public function testUpdateRestrictionWithInvalidParams($params): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->branchRestrictions->update('gentle', 'eof', 1, $params);
    }

    public function testCreateRestrictionShouldFailIfKindIsSpecified(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $params = [
            'kind' => 'invalid'
        ];

        $this->branchRestrictions->update('gentle', 'eof', 1, $params);
    }

    public function testDeleteRestriction(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/branch-restrictions/1';

        $this->branchRestrictions->delete('gentle', 'eof', 1);

        $this->assertRequest('DELETE', $endpoint);
    }
}
