<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\Unit\Providers\Http\Collections;

use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Providers\Http\Collections\HeadersCollection;

/**
 * Tests for HeadersCollection class.
 *
 * @covers \WordPress\AiClient\Providers\Http\Collections\HeadersCollection
 */
class HeadersCollectionTest extends TestCase
{
    /**
     * Tests constructor with initial headers.
     *
     * @return void
     */
    public function testConstructorWithHeaders(): void
    {
        $headers = new HeadersCollection([
            'Content-Type' => 'application/json',
            'X-Custom' => ['value1', 'value2'],
        ]);

        $this->assertEquals(['application/json'], $headers->get('Content-Type'));
        $this->assertEquals(['value1', 'value2'], $headers->get('X-Custom'));
    }

    /**
     * Tests case-insensitive header access.
     *
     * @return void
     */
    public function testCaseInsensitiveAccess(): void
    {
        $headers = new HeadersCollection(['Content-Type' => 'application/json']);

        $this->assertEquals(['application/json'], $headers->get('Content-Type'));
        $this->assertEquals(['application/json'], $headers->get('content-type'));
        $this->assertEquals(['application/json'], $headers->get('CONTENT-TYPE'));
    }

    /**
     * Tests that original header casing is preserved.
     *
     * @return void
     */
    public function testPreservesOriginalCasing(): void
    {
        $headers = new HeadersCollection(['Content-Type' => 'application/json']);

        $all = $headers->getAll();
        $this->assertArrayHasKey('Content-Type', $all);
        $this->assertArrayNotHasKey('content-type', $all);
    }

    /**
     * Tests case-insensitive header replacement.
     *
     * @return void
     */
    public function testCaseInsensitiveReplacement(): void
    {
        $headers = new HeadersCollection(['Content-Type' => 'application/json']);

        // withHeader with different casing should replace existing
        $newHeaders = $headers->withHeader('content-type', 'text/html');

        $this->assertEquals(['text/html'], $newHeaders->get('Content-Type'));

        // Original casing should be preserved
        $all = $newHeaders->getAll();
        $this->assertArrayHasKey('Content-Type', $all);
        $this->assertArrayNotHasKey('content-type', $all);
    }

    /**
     * Tests getAsString method.
     *
     * @return void
     */
    public function testGetAsString(): void
    {
        $headers = new HeadersCollection([
            'Accept' => ['application/json', 'application/xml'],
            'Content-Type' => 'text/html',
        ]);

        $this->assertEquals('application/json, application/xml', $headers->getAsString('Accept'));
        $this->assertEquals('text/html', $headers->getAsString('Content-Type'));
        $this->assertNull($headers->getAsString('Non-Existent'));
    }

    /**
     * Tests has method.
     *
     * @return void
     */
    public function testHas(): void
    {
        $headers = new HeadersCollection(['Content-Type' => 'application/json']);

        $this->assertTrue($headers->has('Content-Type'));
        $this->assertTrue($headers->has('content-type'));
        $this->assertTrue($headers->has('CONTENT-TYPE'));
        $this->assertFalse($headers->has('Accept'));
    }

    /**
     * Tests withHeader immutability.
     *
     * @return void
     */
    public function testWithHeaderImmutability(): void
    {
        $original = new HeadersCollection(['Content-Type' => 'application/json']);

        $new = $original->withHeader('Accept', 'text/html');

        $this->assertNotSame($original, $new);
        $this->assertNull($original->get('Accept'));
        $this->assertEquals(['text/html'], $new->get('Accept'));
        $this->assertEquals(['application/json'], $original->get('Content-Type'));
    }
}
