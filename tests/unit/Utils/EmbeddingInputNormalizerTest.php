<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\unit\Utils;

use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Messages\DTO\MessagePart;
use WordPress\AiClient\Messages\DTO\UserMessage;
use WordPress\AiClient\Utils\PromptNormalizer;

/**
 * @covers \WordPress\AiClient\Utils\PromptNormalizer::normalizeEmbeddingInput
 * @covers \WordPress\AiClient\Utils\PromptNormalizer::isValidEmbeddingInput
 * @covers \WordPress\AiClient\Utils\PromptNormalizer::getEmbeddingInputCount
 */
class EmbeddingInputNormalizerTest extends TestCase
{
    /**
     * Tests normalizing string array input.
     */
    public function testNormalizeStringArray(): void
    {
        $input = ['First text', 'Second text', 'Third text'];
        $result = PromptNormalizer::normalizeEmbeddingInput($input);

        $this->assertCount(3, $result);

        // Check first message
        $this->assertInstanceOf(UserMessage::class, $result[0]);
        $this->assertCount(1, $result[0]->getParts());
        $this->assertEquals('First text', $result[0]->getParts()[0]->getText());

        // Check second message
        $this->assertInstanceOf(UserMessage::class, $result[1]);
        $this->assertEquals('Second text', $result[1]->getParts()[0]->getText());

        // Check third message
        $this->assertInstanceOf(UserMessage::class, $result[2]);
        $this->assertEquals('Third text', $result[2]->getParts()[0]->getText());
    }

    /**
     * Tests normalizing single string input.
     */
    public function testNormalizeSingleString(): void
    {
        $input = 'Single text input';
        $result = PromptNormalizer::normalizeEmbeddingInput($input);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(UserMessage::class, $result[0]);
        $this->assertEquals('Single text input', $result[0]->getParts()[0]->getText());
    }

    /**
     * Tests normalizing MessagePart input.
     */
    public function testNormalizeMessagePart(): void
    {
        $messagePart = new MessagePart('Test message part');
        $result = PromptNormalizer::normalizeEmbeddingInput($messagePart);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(UserMessage::class, $result[0]);
        $this->assertSame($messagePart, $result[0]->getParts()[0]);
    }

    /**
     * Tests normalizing single Message input.
     */
    public function testNormalizeSingleMessage(): void
    {
        $message = new UserMessage([new MessagePart('Test message')]);
        $result = PromptNormalizer::normalizeEmbeddingInput($message);

        $this->assertCount(1, $result);
        $this->assertSame($message, $result[0]);
    }

    /**
     * Tests normalizing array of Messages.
     */
    public function testNormalizeMessageArray(): void
    {
        $message1 = new UserMessage([new MessagePart('First message')]);
        $message2 = new UserMessage([new MessagePart('Second message')]);
        $messages = [$message1, $message2];

        $result = PromptNormalizer::normalizeEmbeddingInput($messages);

        $this->assertCount(2, $result);
        $this->assertSame($message1, $result[0]);
        $this->assertSame($message2, $result[1]);
    }

    /**
     * Tests normalizing array of MessageParts.
     */
    public function testNormalizeMessagePartArray(): void
    {
        $part1 = new MessagePart('First part');
        $part2 = new MessagePart('Second part');
        $parts = [$part1, $part2];

        $result = PromptNormalizer::normalizeEmbeddingInput($parts);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(UserMessage::class, $result[0]);
        $this->assertInstanceOf(UserMessage::class, $result[1]);
        $this->assertSame($part1, $result[0]->getParts()[0]);
        $this->assertSame($part2, $result[1]->getParts()[0]);
    }

    /**
     * Tests mixed array with non-string elements throws exception.
     */
    public function testNormalizeMixedStringArrayThrowsException(): void
    {
        $input = ['Valid string', 123, 'Another string'];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Array element at index 1 must be a string, integer given');

        PromptNormalizer::normalizeEmbeddingInput($input);
    }

    /**
     * Tests empty string array throws exception.
     */
    public function testNormalizeEmptyArrayThrowsException(): void
    {
        $input = [];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Prompt array cannot be empty');

        PromptNormalizer::normalizeEmbeddingInput($input);
    }

    /**
     * Tests invalid input type throws exception.
     */
    public function testNormalizeInvalidInputThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid prompt format provided');

        PromptNormalizer::normalizeEmbeddingInput(123);
    }

    /**
     * Tests isValidEmbeddingInput returns true for valid inputs.
     */
    public function testIsValidEmbeddingInputReturnsTrueForValidInputs(): void
    {
        $this->assertTrue(PromptNormalizer::isValidEmbeddingInput('Single string'));
        $this->assertTrue(PromptNormalizer::isValidEmbeddingInput(['String array', 'element']));
        $this->assertTrue(PromptNormalizer::isValidEmbeddingInput(new MessagePart('Test')));
        $this->assertTrue(PromptNormalizer::isValidEmbeddingInput(
            new UserMessage([new MessagePart('Test')])
        ));
    }

    /**
     * Tests isValidEmbeddingInput returns false for invalid inputs.
     */
    public function testIsValidEmbeddingInputReturnsFalseForInvalidInputs(): void
    {
        $this->assertFalse(PromptNormalizer::isValidEmbeddingInput(123));
        $this->assertFalse(PromptNormalizer::isValidEmbeddingInput([]));
        $this->assertFalse(PromptNormalizer::isValidEmbeddingInput(['valid', 123]));
        $this->assertFalse(PromptNormalizer::isValidEmbeddingInput(new \stdClass()));
    }

    /**
     * Tests getInputCount returns correct count for various inputs.
     */
    public function testGetInputCountReturnsCorrectCount(): void
    {
        $this->assertEquals(1, PromptNormalizer::getEmbeddingInputCount('Single string'));
        $this->assertEquals(3, PromptNormalizer::getEmbeddingInputCount(['One', 'Two', 'Three']));
        $this->assertEquals(1, PromptNormalizer::getEmbeddingInputCount(new MessagePart('Test')));

        $messages = [
            new UserMessage([new MessagePart('First')]),
            new UserMessage([new MessagePart('Second')])
        ];
        $this->assertEquals(2, PromptNormalizer::getEmbeddingInputCount($messages));
    }

    /**
     * Tests getInputCount throws exception for invalid input.
     */
    public function testGetInputCountThrowsExceptionForInvalidInput(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid prompt format provided');

        PromptNormalizer::getEmbeddingInputCount(123);
    }

    /**
     * Tests that string array normalization preserves order.
     */
    public function testStringArrayNormalizationPreservesOrder(): void
    {
        $input = ['First', 'Second', 'Third', 'Fourth'];
        $result = PromptNormalizer::normalizeEmbeddingInput($input);

        $this->assertCount(4, $result);
        $this->assertEquals('First', $result[0]->getParts()[0]->getText());
        $this->assertEquals('Second', $result[1]->getParts()[0]->getText());
        $this->assertEquals('Third', $result[2]->getParts()[0]->getText());
        $this->assertEquals('Fourth', $result[3]->getParts()[0]->getText());
    }
}
