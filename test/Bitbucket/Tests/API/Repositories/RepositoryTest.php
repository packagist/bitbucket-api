<?php

namespace Bitbucket\Tests\API\Repositories;

use Bitbucket\Tests\API as Tests;
use Bitbucket\API;

class RepositoryTest extends Tests\TestCase
{
    public function testGetRepository()
    {
        $endpoint       = 'repositories/gentle/eof';
        $expectedResult = $this->fakeResponse(array('dummy'));

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->will($this->returnValue($expectedResult));

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo   = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);
        $actual = $repo->get('gentle', 'eof');

        $this->assertEquals($expectedResult, $actual);
    }

    /**
     * @return array of invalid value for repo creations parameter
     */
    public function invalidCreateProvider()
    {
        return array(
            array(''),
            array(3),
            array("\t"),
            array("\n"),
            array(' '),
            array("{ 'bar': 'baz' }"),
            array('{ repo: "company", }'),
            array('{ repo: "company" }'),
            array(
                substr(
                    "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",
                    mt_rand(0, 50), 1).substr(md5(time()), 1),
            ),
        );
    }

    /**
     * @param mixed $check
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidCreateProvider
     * @ticket 27, 26
     */
    public function testInvalidCreate($check)
    {
        $client = $this->getHttpClientMock();

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);
        $this->setExpectedException('\InvalidArgumentException');
        $repo->create('gentle', 'new-repo', $check);
    }

    public function testCreateRepositoryFromJSON()
    {
        $endpoint       = 'repositories/gentle/new-repo';
        $params         = json_encode(array(
            'scm'               => 'git',
            'name'              => 'new-repo',
            'is_private'        => true,
            'description'       => 'My secret repo',
            'fork_policy'       => 'no_public_forks',
        ));

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('post')
            ->with($endpoint, $params);

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo   = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);

        $repo->create('gentle', 'new-repo', $params);
    }

    public function testCreateRepositoryFromArray()
    {
        $endpoint       = 'repositories/gentle/new-repo';
        $params         = array(
            'scm'               => 'git',
            'name'              => 'new-repo',
            'is_private'        => true,
            'description'       => 'My secret repo',
            'fork_policy'       => 'no_public_forks',
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('post')
            ->with($endpoint, json_encode($params));

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo   = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);

        $repo->create('gentle', 'new-repo', $params);
    }

    /**
     * @ticket 26
     */
    public function testCreateRepositoryWithDefaultParams()
    {
        $endpoint       = 'repositories/gentle/new-repo';
        $params         = array(
            'scm'               => 'git',
            'name'              => 'new-repo',
            'is_private'        => true,
            'description'       => 'My secret repo',
            'fork_policy'       => 'no_forks',
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('post')
            ->with($endpoint, json_encode($params));

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo   = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);

        $repo->create('gentle', 'new-repo', array());
    }

    public function testUpdateRepositorySuccess()
    {
        $endpoint       = 'repositories/gentle/eof';
        $params         = array(
            'description'   => 'My super secret project',
            'language'      => 'php',
            'is_private'    => false,
            'main_branch'   => 'master',
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('put')
            ->with($endpoint, $params);

        /** @var $repository \Bitbucket\API\Repositories\Repository */
        $repository   = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);
        $repository->update('gentle', 'eof', $params);
    }

    public function testDeleteRepository()
    {
        $endpoint       = 'repositories/gentle/eof';

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('delete')
            ->with($endpoint);

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo   = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);

        $repo->delete('gentle', 'eof');
    }

    public function testGetRepositoryWatchers()
    {
        $endpoint       = 'repositories/gentle/eof/watchers';
        $expectedResult = $this->fakeResponse(array('dummy'));

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo   = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);
        $actual = $repo->watchers('gentle', 'eof');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetRepositoryForks()
    {
        $endpoint       = 'repositories/gentle/eof/forks';
        $expectedResult = $this->fakeResponse(array('dummy'));

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo   = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);
        $actual = $repo->forks('gentle', 'eof');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testForkRepositorySuccess()
    {
        $endpoint       = 'repositories/gentle/eof/forks';
        $params         = array(
            'is_private'    => true,
            'name'          => 'my-eof',
        );

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('post')
            ->with($endpoint, json_encode($params));

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);

        /** @var $repository \Bitbucket\API\Repositories\Repository */
        $repo->fork('gentle', 'eof', 'my-eof', array('is_private' => true));
    }

    public function testGetBranches()
    {
        $endpoint       = 'repositories/gentle/eof/refs/branches/';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $repository \Bitbucket\API\Repositories\Repository */
        $repository = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);
        $actual = $repository->branches('gentle', 'eof');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetTags()
    {
        $endpoint       = 'repositories/gentle/eof/refs/tags/tagname';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var \Bitbucket\API\Repositories\Repository $repo */
        $repo   = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);
        $actual = $repo->tags('gentle', 'eof', 'tagname');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetFileHistory()
    {
        $endpoint       = 'repositories/gentle/eof/filehistory/1bc8345/lib/file.php';
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($expectedResult);

        /** @var $repository \Bitbucket\API\Repositories\Repository */
        $repository = $this->getClassMock('Bitbucket\API\Repositories\Repository', $client);
        $actual = $repository->filehistory('gentle', 'eof', '1bc8345', 'lib/file.php');

        $this->assertEquals($expectedResult, $actual);
    }
}
