<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\unit\Operations;

use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Messages\DTO\MessagePart;
use WordPress\AiClient\Messages\DTO\UserMessage;
use WordPress\AiClient\Operations\DTO\EmbeddingOperation;
use WordPress\AiClient\Operations\DTO\GenerativeAiOperation;
use WordPress\AiClient\Operations\Enums\OperationStateEnum;
use WordPress\AiClient\Operations\OperationFactory;

/**
 * @covers \WordPress\AiClient\Operations\OperationFactory
 */
class OperationFactoryTest extends TestCase
{
    private array $testMessages;

    protected function setUp(): void
    {
        $this->testMessages = [
            new UserMessage([new MessagePart('Test message 1')]),
            new UserMessage([new MessagePart('Test message 2')])
        ];
    }

    /**
     * Tests createGenericOperation creates operation with correct prefix.
     */
    public function testCreateGenericOperation(): void
    {
        $operation = OperationFactory::createGenericOperation($this->testMessages);

        $this->assertInstanceOf(GenerativeAiOperation::class, $operation);
        $this->assertStringStartsWith('op_', $operation->getId());
        $this->assertEquals(OperationStateEnum::starting(), $operation->getState());
        $this->assertNull($operation->getResult());
    }

    /**
     * Tests createTextOperation creates operation with correct prefix.
     */
    public function testCreateTextOperation(): void
    {
        $operation = OperationFactory::createTextOperation($this->testMessages);

        $this->assertInstanceOf(GenerativeAiOperation::class, $operation);
        $this->assertStringStartsWith('text_op_', $operation->getId());
        $this->assertEquals(OperationStateEnum::starting(), $operation->getState());
        $this->assertNull($operation->getResult());
    }

    /**
     * Tests createImageOperation creates operation with correct prefix.
     */
    public function testCreateImageOperation(): void
    {
        $operation = OperationFactory::createImageOperation($this->testMessages);

        $this->assertInstanceOf(GenerativeAiOperation::class, $operation);
        $this->assertStringStartsWith('image_op_', $operation->getId());
        $this->assertEquals(OperationStateEnum::starting(), $operation->getState());
        $this->assertNull($operation->getResult());
    }

    /**
     * Tests createTextToSpeechOperation creates operation with correct prefix.
     */
    public function testCreateTextToSpeechOperation(): void
    {
        $operation = OperationFactory::createTextToSpeechOperation($this->testMessages);

        $this->assertInstanceOf(GenerativeAiOperation::class, $operation);
        $this->assertStringStartsWith('tts_op_', $operation->getId());
        $this->assertEquals(OperationStateEnum::starting(), $operation->getState());
        $this->assertNull($operation->getResult());
    }

    /**
     * Tests createSpeechOperation creates operation with correct prefix.
     */
    public function testCreateSpeechOperation(): void
    {
        $operation = OperationFactory::createSpeechOperation($this->testMessages);

        $this->assertInstanceOf(GenerativeAiOperation::class, $operation);
        $this->assertStringStartsWith('speech_op_', $operation->getId());
        $this->assertEquals(OperationStateEnum::starting(), $operation->getState());
        $this->assertNull($operation->getResult());
    }

    /**
     * Tests createEmbeddingOperation creates embedding operation with correct prefix.
     */
    public function testCreateEmbeddingOperation(): void
    {
        $operation = OperationFactory::createEmbeddingOperation($this->testMessages);

        $this->assertInstanceOf(EmbeddingOperation::class, $operation);
        $this->assertStringStartsWith('embedding_op_', $operation->getId());
        $this->assertEquals(OperationStateEnum::starting(), $operation->getState());
        $this->assertNull($operation->getResult());
    }

    /**
     * Tests getOperationPrefix returns correct prefix for known types.
     */
    public function testGetOperationPrefixReturnsCorrectPrefix(): void
    {
        $this->assertEquals('op_', OperationFactory::getOperationPrefix('generic'));
        $this->assertEquals('text_op_', OperationFactory::getOperationPrefix('text'));
        $this->assertEquals('image_op_', OperationFactory::getOperationPrefix('image'));
        $this->assertEquals('tts_op_', OperationFactory::getOperationPrefix('textToSpeech'));
        $this->assertEquals('speech_op_', OperationFactory::getOperationPrefix('speech'));
        $this->assertEquals('embedding_op_', OperationFactory::getOperationPrefix('embedding'));
    }

    /**
     * Tests getOperationPrefix throws exception for unknown type.
     */
    public function testGetOperationPrefixThrowsExceptionForUnknownType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported operation type: unknown');

        OperationFactory::getOperationPrefix('unknown');
    }

    /**
     * Tests getOperationPrefixes returns all available prefixes.
     */
    public function testGetOperationPrefixesReturnsAllPrefixes(): void
    {
        $prefixes = OperationFactory::getOperationPrefixes();

        $expected = [
            'generic' => 'op_',
            'text' => 'text_op_',
            'image' => 'image_op_',
            'textToSpeech' => 'tts_op_',
            'speech' => 'speech_op_',
            'embedding' => 'embedding_op_',
        ];

        $this->assertEquals($expected, $prefixes);
        $this->assertCount(6, $prefixes);
    }

    /**
     * Tests that operation IDs are unique across multiple calls.
     */
    public function testOperationIdsAreUnique(): void
    {
        $operation1 = OperationFactory::createTextOperation($this->testMessages);
        $operation2 = OperationFactory::createTextOperation($this->testMessages);

        $this->assertNotEquals($operation1->getId(), $operation2->getId());
    }

    /**
     * Tests that operation IDs contain uniqid entropy.
     */
    public function testOperationIdsContainEntropy(): void
    {
        $operation = OperationFactory::createTextOperation($this->testMessages);

        // Should contain more than just the prefix
        $this->assertGreaterThan(strlen('text_op_'), strlen($operation->getId()));

        // Should contain the prefix
        $this->assertStringStartsWith('text_op_', $operation->getId());
    }
}
