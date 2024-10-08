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

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Client\Response\UserGroupValidationResponse;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class UserGroupValidationResponseTest extends TestCase
{
    public function testSuccessfulResponse(): UserGroupValidationResponse
    {
        $response = new UserGroupValidationResponse('{"status":1,"group":0,"devices":["test-device-1", "test-device-2"],"licenses":["Android","iOS"],"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());

        return $response;
    }

    public function testUnsuccessfulResponse(): void
    {
        $response = new UserGroupValidationResponse('{"user":"invalid","errors":["user key is invalid"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(UserGroupValidationResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'user key is invalid'], $response->getErrors());
    }

    #[Depends('testSuccessfulResponse')]
    public function testGetDevices(UserGroupValidationResponse $response): void
    {
        $this->assertSame(['test-device-1', 'test-device-2'], $response->getDevices());
    }

    #[Depends('testSuccessfulResponse')]
    public function testGetIsGroup(UserGroupValidationResponse $response): void
    {
        $this->assertFalse($response->isGroup());
    }

    #[Depends('testSuccessfulResponse')]
    public function testGetLicenses(UserGroupValidationResponse $response): void
    {
        $this->assertSame(['Android', 'iOS'], $response->getLicenses());
    }
}
