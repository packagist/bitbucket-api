<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\API\Repositories\Repository;
use Bitbucket\Tests\API\TestCase;

class RepositoryTest extends TestCase
{
    /** @var Repository */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->getApiMock(Repository::class);
    }

    public function testGetRepository(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->repository->get('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    /**
     * @return array of invalid value for repo creations parameter
     */
    public function invalidCreateProvider(): array
    {
        return [
            [''],
            [3],
            ["\t"],
            ["\n"],
            [' '],
            ["{ 'bar': 'baz' }"],
            ['{ repo: "company", }'],
            ['{ repo: "company" }'],
            [
                substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 50), 1)
                .substr(md5((string)time()), 1),
            ],
        ];
    }

    /**
     * @param mixed $check
     * @dataProvider invalidCreateProvider
     * @ticket 27, 26
     */
    public function testInvalidCreate($check): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->repository->create('gentle', 'new-repo', $check);
    }

    public function testCreateRepositoryFromJSON(): void
    {
        $endpoint = '/2.0/repositories/gentle/new-repo';
        $params = json_encode([
            'scm' => 'git',
            'name' => 'new-repo',
            'is_private' => true,
            'description' => 'My secret repo',
            'fork_policy' => 'no_public_forks',
        ]);

        $this->repository->create('gentle', 'new-repo', $params);

        $this->assertRequest('POST', $endpoint, $params);
    }

    public function testCreateRepositoryFromArray(): void
    {
        $endpoint = '/2.0/repositories/gentle/new-repo';
        $params = [
            'scm' => 'git',
            'name' => 'new-repo',
            'is_private' => true,
            'description' => 'My secret repo',
            'fork_policy' => 'no_public_forks',
        ];

        $this->repository->create('gentle', 'new-repo', $params);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    /**
     * @ticket 26
     */
    public function testCreateRepositoryWithDefaultParams(): void
    {
        $endpoint = '/2.0/repositories/gentle/new-repo';
        $params = [
            'scm'=> 'git',
            'name' => 'new-repo',
            'is_private'=> true,
            'description'=> 'My secret repo',
            'fork_policy'=> 'no_forks',
        ];

        $this->repository->create('gentle', 'new-repo', []);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testUpdateRepositorySuccess(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof';
        $params = [
            'description' => 'My super secret project',
            'language' => 'php',
            'is_private' => false,
            'main_branch' => 'master',
        ];

        $this->repository->update('gentle', 'eof', $params);

        $this->assertRequest('PUT', $endpoint, http_build_query($params));
    }

    public function testDeleteRepository(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof';

        $this->repository->delete('gentle', 'eof');

        $this->assertRequest('DELETE', $endpoint);
    }

    public function testGetRepositoryWatchers(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/watchers';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->repository->watchers('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetRepositoryForks(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/forks';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->repository->forks('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testForkRepositorySuccess(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/forks';
        $params = [
            'is_private' => true,
            'name' => 'my-eof',
        ];

        $this->repository->fork('gentle', 'eof', 'my-eof', ['is_private' => true]);

        $this->assertRequest('POST', $endpoint, json_encode($params));
    }

    public function testGetBranches(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/refs/branches/';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->repository->branches('gentle', 'eof');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetTags(): void
    {
        $endpoint= '/2.0/repositories/gentle/eof/refs/tags/tagname';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->repository->tags('gentle', 'eof', 'tagname');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }

    public function testGetFileHistory(): void
    {
        $endpoint = '/2.0/repositories/gentle/eof/filehistory/1bc8345/lib/file.php';
        $expectedResult = $this->fakeResponse(['dummy']);

        $actual = $this->repository->filehistory('gentle', 'eof', '1bc8345', 'lib/file.php');

        $this->assertRequest('GET', $endpoint);
        $this->assertResponse($expectedResult, $actual);
    }
}
