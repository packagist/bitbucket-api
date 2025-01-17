<?php
/**
 * This file is part of the bitbucket-api package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bitbucket\API\Http\Response;

use Psr\Http\Message\MessageInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
interface PagerInterface
{
    /**
     * @return bool
     */
    public function hasNext();

    /**
     * @return bool
     */
    public function hasPrevious();

    /**
     * Fetch next page and return http response
     *
     * @return MessageInterface|null
     */
    public function fetchNext();

    /**
     * Fetch previous page and return http response
     *
     * @return MessageInterface|null
     */
    public function fetchPrevious();

    /**
     * Fetch all available pages.
     *
     * @return MessageInterface
     */
    public function fetchAll();

    /**
     * Get current http response.
     *
     * @return MessageInterface
     */
    public function getCurrent();
}
