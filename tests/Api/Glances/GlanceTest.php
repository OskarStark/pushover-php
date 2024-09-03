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

namespace Api\Glances;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Serhiy\Pushover\Api\Glances\Glance;
use Serhiy\Pushover\Api\Glances\GlanceDataFields;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Client\Response\GlancesResponse;
use Serhiy\Pushover\Recipient;

/**
 * @author Serhiy Lunak <serhiy.lunak@gmail.com>
 */
final class GlanceTest extends TestCase
{
    public function testCanBeConstructed(): Glance
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $glanceDataFields = new GlanceDataFields();

        $glance = new Glance($application, $glanceDataFields);
        $glance->setRecipient($recipient);

        $this->assertInstanceOf(Glance::class, $glance);

        return $glance;
    }

    #[Depends('testCanBeConstructed')]
    public function testGetGlanceDataFields(Glance $glance): void
    {
        $this->assertInstanceOf(GlanceDataFields::class, $glance->getGlanceDataFields());
    }

    #[Depends('testCanBeConstructed')]
    public function testGetApplication(Glance $glance): void
    {
        $this->assertInstanceOf(Application::class, $glance->getApplication());
    }

    #[Depends('testCanBeConstructed')]
    public function testGetRecipient(Glance $glance): void
    {
        $this->assertInstanceOf(Recipient::class, $glance->getRecipient());
    }

    #[Depends('testCanBeConstructed')]
    public function testSetApplication(Glance $glance): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $glance->setApplication($application);

        $this->assertInstanceOf(Application::class, $glance->getApplication());
    }

    #[Depends('testCanBeConstructed')]
    public function testSetGlanceDataFields(Glance $glance): void
    {
        $glanceDataFields = new GlanceDataFields();
        $glance->setGlanceDataFields($glanceDataFields);

        $this->assertInstanceOf(GlanceDataFields::class, $glance->getGlanceDataFields());
    }

    #[Depends('testCanBeConstructed')]
    public function testSetRecipient(Glance $glance): void
    {
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key
        $glance->setRecipient($recipient);

        $this->assertInstanceOf(Recipient::class, $recipient);
    }

    #[DataProvider('hasAtLeastOneFieldProvider')]
    public function testHasAtLeastOneField(bool $expected, ?string $title, ?string $subtext, ?int $count, ?int $percent): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $glanceDataFields = (new GlanceDataFields())
            ->setTitle($title)
            ->setSubtext($subtext)
            ->setCount($count)
            ->setPercent($percent);

        $glance = new Glance($application, $glanceDataFields);

        $this->assertSame($expected, $glance->hasAtLeastOneField());
    }

    /**
     * @return iterable<array{bool, ?string, ?string, ?int, ?int}>
     */
    public static function hasAtLeastOneFieldProvider(): iterable
    {
        yield [false, null, null, null, null];
        yield [true, 'Title', null, null, null];
        yield [true, null, 'Subtext', null, null];
        yield [true, null, null, 199, null];
        yield [true, null, null, null, 99];
    }

    #[Depends('testCanBeConstructed')]
    public function testHasRecipient(Glance $glance): void
    {
        $this->assertTrue($glance->hasRecipient());
    }

    #[Group('Integration')]
    public function testPush(): void
    {
        $application = new Application('cccc3333CCCC3333dddd4444DDDD44'); // using dummy token
        $recipient = new Recipient('aaaa1111AAAA1111bbbb2222BBBB22'); // using dummy user key

        $glanceDataFields = (new GlanceDataFields())
            ->setTitle('Title')
            ->setText('Text Test')
            ->setSubtext('Subtext Test')
            ->setCount(199)
            ->setPercent(99);

        $glance = new Glance($application, $glanceDataFields);
        $glance->setRecipient($recipient);
        $response = $glance->push();

        $this->assertInstanceOf(GlancesResponse::class, $response);
    }
}
