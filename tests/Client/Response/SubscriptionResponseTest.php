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
use Serhiy\Pushover\Client\Response\SubscriptionResponse;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class SubscriptionResponseTest extends TestCase
{
    public function testCanBeConstructedWithSuccessfulResponse(): void
    {
        $response = new SubscriptionResponse('{"subscribed_user_key":"aaaa1111AAAA1111bbbb2222BBBB22","status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(SubscriptionResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
    }

    public function testCanBeConstructedWithUnsuccessfulResponse(): void
    {
        $response = new SubscriptionResponse('{"subscription":"invalid","errors":["subscription code is invalid"],"status":0,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertInstanceOf(SubscriptionResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('aaaaaaaa-1111-bbbb-2222-cccccccccccc', $response->getRequestToken());
        $this->assertSame([0 => 'subscription code is invalid'], $response->getErrors());
    }

    public function testGetSubscribedUserKey(): void
    {
        $response = new SubscriptionResponse('{"subscribed_user_key":"aaaa1111AAAA1111bbbb2222BBBB22","status":1,"request":"aaaaaaaa-1111-bbbb-2222-cccccccccccc"}');

        $this->assertSame('aaaa1111AAAA1111bbbb2222BBBB22', $response->getSubscribedUserKey());
    }
}
