<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\Unit\Common\Utilities;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Common\Utilities\Prompts;
use WordPress\AiClient\Messages\DTO\MessagePart;
use WordPress\AiClient\Messages\DTO\UserMessage;

/**
 * Tests for the Prompts utility class.
 *
 * @since n.e.x.t
 *
 * @covers \WordPress\AiClient\Common\Utilities\Prompts
 */
class PromptsTest extends TestCase
{
    /**
     * Tests normalizing a simple string to messages.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithString(): void
    {
        $result = Prompts::normalizeToMessages('Hello, world!');

        $this->assertCount(1, $result);
        $this->assertInstanceOf(UserMessage::class, $result[0]);

        $parts = $result[0]->getParts();
        $this->assertCount(1, $parts);
        $this->assertEquals('Hello, world!', $parts[0]->getText());
    }

    /**
     * Tests normalizing a single MessagePart to messages.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithMessagePart(): void
    {
        $part = new MessagePart('Test content');
        $result = Prompts::normalizeToMessages($part);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(UserMessage::class, $result[0]);

        $parts = $result[0]->getParts();
        $this->assertCount(1, $parts);
        $this->assertEquals('Test content', $parts[0]->getText());
    }

    /**
     * Tests normalizing a single Message.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithMessage(): void
    {
        $message = new UserMessage([new MessagePart('Test message')]);
        $result = Prompts::normalizeToMessages($message);

        $this->assertCount(1, $result);
        $this->assertSame($message, $result[0]);
    }

    /**
     * Tests normalizing a MessageArrayShape.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithMessageArrayShape(): void
    {
        $arrayShape = [
            'role' => 'user',
            'parts' => [
                [
                    'channel' => 'content',
                    'type' => 'text',
                    'text' => 'Hello from array'
                ]
            ]
        ];

        $result = Prompts::normalizeToMessages($arrayShape);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(UserMessage::class, $result[0]);

        $parts = $result[0]->getParts();
        $this->assertCount(1, $parts);
        $this->assertEquals('Hello from array', $parts[0]->getText());
    }

    /**
     * Tests normalizing a list of strings to messages.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithListOfStrings(): void
    {
        $result = Prompts::normalizeToMessages(['First part', 'Second part', 'Third part']);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(UserMessage::class, $result[0]);

        $parts = $result[0]->getParts();
        $this->assertCount(3, $parts);
        $this->assertEquals('First part', $parts[0]->getText());
        $this->assertEquals('Second part', $parts[1]->getText());
        $this->assertEquals('Third part', $parts[2]->getText());
    }

    /**
     * Tests normalizing a list of MessageParts to messages.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithListOfMessageParts(): void
    {
        $parts = [
            new MessagePart('Part 1'),
            new MessagePart('Part 2')
        ];

        $result = Prompts::normalizeToMessages($parts);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(UserMessage::class, $result[0]);

        $messageParts = $result[0]->getParts();
        $this->assertCount(2, $messageParts);
        $this->assertEquals('Part 1', $messageParts[0]->getText());
        $this->assertEquals('Part 2', $messageParts[1]->getText());
    }

    /**
     * Tests normalizing a mixed list of strings and MessageParts.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithMixedList(): void
    {
        $items = [
            'String part',
            new MessagePart('MessagePart object'),
            [
                'channel' => 'content',
                'type' => 'text',
                'text' => 'Array shape part'
            ]
        ];

        $result = Prompts::normalizeToMessages($items);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(UserMessage::class, $result[0]);

        $parts = $result[0]->getParts();
        $this->assertCount(3, $parts);
        $this->assertEquals('String part', $parts[0]->getText());
        $this->assertEquals('MessagePart object', $parts[1]->getText());
        $this->assertEquals('Array shape part', $parts[2]->getText());
    }

    /**
     * Tests normalizing a list of Messages.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithListOfMessages(): void
    {
        $messages = [
            new UserMessage([new MessagePart('First message')]),
            new UserMessage([new MessagePart('Second message')])
        ];

        $result = Prompts::normalizeToMessages($messages);

        $this->assertCount(2, $result);
        $this->assertSame($messages[0], $result[0]);
        $this->assertSame($messages[1], $result[1]);
    }

    /**
     * Tests that invalid input throws an exception.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithInvalidInput(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid item type integer in prompt.');

        Prompts::normalizeToMessages(123);
    }

    /**
     * Tests that invalid item in list throws an exception.
     *
     * @since n.e.x.t
     */
    public function testNormalizeToMessagesWithInvalidItemInList(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid item type integer in prompt.');

        Prompts::normalizeToMessages(['Valid string', 123]);
    }
}
