<?php

declare(strict_types=1);

/**
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Client\Request;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Client\Request\Request;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class RequestTest extends TestCase
{
    public function testCanBeCrated(): Request
    {
        $request = new Request('https://test.com/api', Request::POST, []);

        $this->assertInstanceOf(Request::class, $request);

        return $request;
    }

    #[Depends('testCanBeCrated')]
    public function testGetMethod(Request $request): void
    {
        $this->assertSame(Request::POST, $request->getMethod());
    }

    #[Depends('testCanBeCrated')]
    public function testGetApiUrl(Request $request): void
    {
        $this->assertSame('https://test.com/api', $request->getApiUrl());
    }
}
