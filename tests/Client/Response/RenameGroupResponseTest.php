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

namespace Client\Response;

use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Client\Response\RenameGroupResponse;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class RenameGroupResponseTest extends TestCase
{
    public function testSuccessfulResponse(): void
    {
        $response = new RenameGroupResponse('{"status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(RenameGroupResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
    }

    public function testUnsuccessfulResponse(): void
    {
        $response = new RenameGroupResponse('{"group":"not found","errors":["group not found or you are not authorized to edit it"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(RenameGroupResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'group not found or you are not authorized to edit it'], $response->getErrors());
    }
}
