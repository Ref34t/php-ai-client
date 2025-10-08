<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\unit\Providers\Http\DTO;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Providers\Http\DTO\RequestOptions;

/**
 * @covers \WordPress\AiClient\Providers\Http\DTO\RequestOptions
 */
class RequestOptionsTest extends TestCase
{
    /**
     * Tests constructor with valid values.
     *
     * @return void
     */
    public function testConstructorWithValidValues(): void
    {
        $options = new RequestOptions(30, 5);

        $this->assertEquals(30, $options->getTimeout());
        $this->assertEquals(5, $options->getMaxRedirects());
    }

    /**
     * Tests constructor with null values.
     *
     * @return void
     */
    public function testConstructorWithNullValues(): void
    {
        $options = new RequestOptions();

        $this->assertNull($options->getTimeout());
        $this->assertNull($options->getMaxRedirects());
    }

    /**
     * Tests constructor with negative timeout throws exception.
     *
     * @return void
     */
    public function testConstructorWithNegativeTimeoutThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Timeout must be between 0 and');

        new RequestOptions(-1, 5);
    }

    /**
     * Tests constructor with negative maxRedirects throws exception.
     *
     * @return void
     */
    public function testConstructorWithNegativeMaxRedirectsThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Max redirects must be between 0 and');

        new RequestOptions(30, -1);
    }

    /**
     * Tests constructor with timeout exceeding maximum throws exception.
     *
     * @return void
     */
    public function testConstructorWithTimeoutExceedingMaxThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Timeout must be between 0 and 3600 seconds.');

        new RequestOptions(3601, 5);
    }

    /**
     * Tests constructor with maxRedirects exceeding maximum throws exception.
     *
     * @return void
     */
    public function testConstructorWithMaxRedirectsExceedingMaxThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Max redirects must be between 0 and 100.');

        new RequestOptions(30, 101);
    }

    /**
     * Tests constructor with maximum allowed values.
     *
     * @return void
     */
    public function testConstructorWithMaximumAllowedValues(): void
    {
        $options = new RequestOptions(
            RequestOptions::MAX_TIMEOUT,
            RequestOptions::MAX_REDIRECTS
        );

        $this->assertEquals(3600, $options->getTimeout());
        $this->assertEquals(100, $options->getMaxRedirects());
    }

    /**
     * Tests withTimeout method.
     *
     * @return void
     */
    public function testWithTimeout(): void
    {
        $options = new RequestOptions(30, 5);
        $newOptions = $options->withTimeout(60);

        $this->assertNotSame($options, $newOptions); // Ensure immutability
        $this->assertEquals(30, $options->getTimeout());
        $this->assertEquals(60, $newOptions->getTimeout());
        $this->assertEquals(5, $newOptions->getMaxRedirects()); // Other properties preserved
    }

    /**
     * Tests withTimeout with null value.
     *
     * @return void
     */
    public function testWithTimeoutNull(): void
    {
        $options = new RequestOptions(30, 5);
        $newOptions = $options->withTimeout(null);

        $this->assertNull($newOptions->getTimeout());
        $this->assertEquals(5, $newOptions->getMaxRedirects());
    }

    /**
     * Tests withTimeout with negative value throws exception.
     *
     * @return void
     */
    public function testWithTimeoutNegativeThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Timeout must be between 0 and');

        $options = new RequestOptions(30, 5);
        $options->withTimeout(-1);
    }

    /**
     * Tests withTimeout exceeding maximum throws exception.
     *
     * @return void
     */
    public function testWithTimeoutExceedingMaxThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Timeout must be between 0 and 3600 seconds.');

        $options = new RequestOptions(30, 5);
        $options->withTimeout(3601);
    }

    /**
     * Tests withMaxRedirects method.
     *
     * @return void
     */
    public function testWithMaxRedirects(): void
    {
        $options = new RequestOptions(30, 5);
        $newOptions = $options->withMaxRedirects(10);

        $this->assertNotSame($options, $newOptions); // Ensure immutability
        $this->assertEquals(5, $options->getMaxRedirects());
        $this->assertEquals(10, $newOptions->getMaxRedirects());
        $this->assertEquals(30, $newOptions->getTimeout()); // Other properties preserved
    }

    /**
     * Tests withMaxRedirects with null value.
     *
     * @return void
     */
    public function testWithMaxRedirectsNull(): void
    {
        $options = new RequestOptions(30, 5);
        $newOptions = $options->withMaxRedirects(null);

        $this->assertNull($newOptions->getMaxRedirects());
        $this->assertEquals(30, $newOptions->getTimeout());
    }

    /**
     * Tests withMaxRedirects with negative value throws exception.
     *
     * @return void
     */
    public function testWithMaxRedirectsNegativeThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Max redirects must be between 0 and');

        $options = new RequestOptions(30, 5);
        $options->withMaxRedirects(-1);
    }

    /**
     * Tests withMaxRedirects exceeding maximum throws exception.
     *
     * @return void
     */
    public function testWithMaxRedirectsExceedingMaxThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Max redirects must be between 0 and 100.');

        $options = new RequestOptions(30, 5);
        $options->withMaxRedirects(101);
    }

    /**
     * Tests hasOptions method returns true when options are set.
     *
     * @return void
     */
    public function testHasOptionsReturnsTrueWhenOptionsSet(): void
    {
        $options1 = new RequestOptions(30, null);
        $options2 = new RequestOptions(null, 5);
        $options3 = new RequestOptions(30, 5);

        $this->assertTrue($options1->hasOptions());
        $this->assertTrue($options2->hasOptions());
        $this->assertTrue($options3->hasOptions());
    }

    /**
     * Tests hasOptions method returns false when no options are set.
     *
     * @return void
     */
    public function testHasOptionsReturnsFalseWhenNoOptionsSet(): void
    {
        $options = new RequestOptions();

        $this->assertFalse($options->hasOptions());
    }

    /**
     * Tests toArray method.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $options = new RequestOptions(30, 5);
        $array = $options->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey(RequestOptions::KEY_TIMEOUT, $array);
        $this->assertArrayHasKey(RequestOptions::KEY_MAX_REDIRECTS, $array);
        $this->assertEquals(30, $array[RequestOptions::KEY_TIMEOUT]);
        $this->assertEquals(5, $array[RequestOptions::KEY_MAX_REDIRECTS]);
    }

    /**
     * Tests toArray method with null values excludes them.
     *
     * @return void
     */
    public function testToArrayExcludesNullValues(): void
    {
        $options = new RequestOptions(30, null);
        $array = $options->toArray();

        $this->assertArrayHasKey(RequestOptions::KEY_TIMEOUT, $array);
        $this->assertArrayNotHasKey(RequestOptions::KEY_MAX_REDIRECTS, $array);
    }

    /**
     * Tests toArray method with all null values returns empty array.
     *
     * @return void
     */
    public function testToArrayWithAllNullReturnsEmptyArray(): void
    {
        $options = new RequestOptions();
        $array = $options->toArray();

        $this->assertIsArray($array);
        $this->assertEmpty($array);
    }

    /**
     * Tests fromArray method.
     *
     * @return void
     */
    public function testFromArray(): void
    {
        $array = [
            RequestOptions::KEY_TIMEOUT => 30,
            RequestOptions::KEY_MAX_REDIRECTS => 5,
        ];

        $options = RequestOptions::fromArray($array);

        $this->assertInstanceOf(RequestOptions::class, $options);
        $this->assertEquals(30, $options->getTimeout());
        $this->assertEquals(5, $options->getMaxRedirects());
    }

    /**
     * Tests fromArray method with partial data.
     *
     * @return void
     */
    public function testFromArrayWithPartialData(): void
    {
        $array = [
            RequestOptions::KEY_TIMEOUT => 30,
        ];

        $options = RequestOptions::fromArray($array);

        $this->assertEquals(30, $options->getTimeout());
        $this->assertNull($options->getMaxRedirects());
    }

    /**
     * Tests fromArray method with empty array.
     *
     * @return void
     */
    public function testFromArrayWithEmptyArray(): void
    {
        $options = RequestOptions::fromArray([]);

        $this->assertNull($options->getTimeout());
        $this->assertNull($options->getMaxRedirects());
    }

    /**
     * Tests getJsonSchema method.
     *
     * @return void
     */
    public function testGetJsonSchema(): void
    {
        $schema = RequestOptions::getJsonSchema();

        $this->assertIsArray($schema);
        $this->assertEquals('object', $schema['type']);
        $this->assertArrayHasKey('properties', $schema);

        // Check timeout property
        $this->assertArrayHasKey(RequestOptions::KEY_TIMEOUT, $schema['properties']);
        $this->assertEquals(['integer', 'null'], $schema['properties'][RequestOptions::KEY_TIMEOUT]['type']);
        $this->assertEquals(0, $schema['properties'][RequestOptions::KEY_TIMEOUT]['minimum']);

        // Check max_redirects property
        $this->assertArrayHasKey(RequestOptions::KEY_MAX_REDIRECTS, $schema['properties']);
        $this->assertEquals(['integer', 'null'], $schema['properties'][RequestOptions::KEY_MAX_REDIRECTS]['type']);
        $this->assertEquals(0, $schema['properties'][RequestOptions::KEY_MAX_REDIRECTS]['minimum']);
    }

    /**
     * Tests defaults method.
     *
     * @return void
     */
    public function testDefaults(): void
    {
        $options = RequestOptions::defaults();

        $this->assertEquals(RequestOptions::DEFAULT_TIMEOUT, $options->getTimeout());
        $this->assertEquals(RequestOptions::DEFAULT_MAX_REDIRECTS, $options->getMaxRedirects());
    }

    /**
     * Tests default constants have correct values.
     *
     * @return void
     */
    public function testDefaultConstants(): void
    {
        $this->assertEquals(30, RequestOptions::DEFAULT_TIMEOUT);
        $this->assertEquals(5, RequestOptions::DEFAULT_MAX_REDIRECTS);
    }
}
