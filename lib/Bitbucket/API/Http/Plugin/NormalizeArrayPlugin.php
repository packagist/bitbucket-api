<?php

/**
 * This file is part of the bitbucketapi package.
 *
 * (c) Alexandru G. <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bitbucket\API\Http\Plugin;

use Http\Client\Common\Plugin;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;

/**
 * Transform PHP array to API array
 *
 * PHP array square brackets does not play nice with remote API,
 * which expects just the key name, without brackets.
 *
 * Transforms: foo[0]=xxx&foo[1]=yyy" to "foo=xxx&foo=yyy"
 *
 * @author  Alexandru G.    <alex@gentle.ro>
 */
class NormalizeArrayPlugin implements Plugin
{
    use Plugin\VersionBridgePlugin;

    /**
     * {@inheritDoc}
     */
    protected function doHandleRequest(RequestInterface $request, callable $next, callable $first)
    {
        // Transform: "foo[0]=xxx&foo[1]=yyy" to "foo=xxx&foo=yyy"
        $request = $request->withUri(
            $request->getUri()->withQuery(
                preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $request->getUri()->getQuery())
            )
        );

        return $next($request);
    }
}
