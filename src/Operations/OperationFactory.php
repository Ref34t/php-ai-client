<?php

declare(strict_types=1);

namespace WordPress\AiClient\Operations;

use WordPress\AiClient\Messages\DTO\Message;
use WordPress\AiClient\Operations\DTO\EmbeddingOperation;
use WordPress\AiClient\Operations\DTO\GenerativeAiOperation;
use WordPress\AiClient\Operations\Enums\OperationStateEnum;

/**
 * Factory class for creating AI operation instances.
 *
 * Centralizes operation creation logic and provides consistent
 * operation ID generation patterns across the AI Client.
 *
 * @since n.e.x.t
 */
class OperationFactory
{
    /**
     * Operation ID prefixes for different operation types.
     */
    private const OPERATION_PREFIXES = [
        'generic' => 'op_',
        'text' => 'text_op_',
        'image' => 'image_op_',
        'textToSpeech' => 'tts_op_',
        'speech' => 'speech_op_',
        'embedding' => 'embedding_op_',
    ];

    /**
     * Creates a generic generation operation.
     *
     * @since n.e.x.t
     *
     * @param list<Message> $messages The normalized messages for the operation.
     * @return GenerativeAiOperation The created operation.
     */
    public static function createGenericOperation(array $messages): GenerativeAiOperation
    {
        return new GenerativeAiOperation(
            uniqid(self::OPERATION_PREFIXES['generic'], true),
            OperationStateEnum::starting(),
            null
        );
    }

    /**
     * Creates a text generation operation.
     *
     * @since n.e.x.t
     *
     * @param list<Message> $messages The normalized messages for the operation.
     * @return GenerativeAiOperation The created operation.
     */
    public static function createTextOperation(array $messages): GenerativeAiOperation
    {
        return new GenerativeAiOperation(
            uniqid(self::OPERATION_PREFIXES['text'], true),
            OperationStateEnum::starting(),
            null
        );
    }

    /**
     * Creates an image generation operation.
     *
     * @since n.e.x.t
     *
     * @param list<Message> $messages The normalized messages for the operation.
     * @return GenerativeAiOperation The created operation.
     */
    public static function createImageOperation(array $messages): GenerativeAiOperation
    {
        return new GenerativeAiOperation(
            uniqid(self::OPERATION_PREFIXES['image'], true),
            OperationStateEnum::starting(),
            null
        );
    }

    /**
     * Creates a text-to-speech conversion operation.
     *
     * @since n.e.x.t
     *
     * @param list<Message> $messages The normalized messages for the operation.
     * @return GenerativeAiOperation The created operation.
     */
    public static function createTextToSpeechOperation(array $messages): GenerativeAiOperation
    {
        return new GenerativeAiOperation(
            uniqid(self::OPERATION_PREFIXES['textToSpeech'], true),
            OperationStateEnum::starting(),
            null
        );
    }

    /**
     * Creates a speech generation operation.
     *
     * @since n.e.x.t
     *
     * @param list<Message> $messages The normalized messages for the operation.
     * @return GenerativeAiOperation The created operation.
     */
    public static function createSpeechOperation(array $messages): GenerativeAiOperation
    {
        return new GenerativeAiOperation(
            uniqid(self::OPERATION_PREFIXES['speech'], true),
            OperationStateEnum::starting(),
            null
        );
    }

    /**
     * Creates an embedding generation operation.
     *
     * @since n.e.x.t
     *
     * @param list<Message> $messages The normalized messages for the operation.
     * @return EmbeddingOperation The created operation.
     */
    public static function createEmbeddingOperation(array $messages): EmbeddingOperation
    {
        return new EmbeddingOperation(
            uniqid(self::OPERATION_PREFIXES['embedding'], true),
            OperationStateEnum::starting(),
            null
        );
    }

    /**
     * Gets the operation prefix for a given operation type.
     *
     * @since n.e.x.t
     *
     * @param string $operationType The operation type (text, image, etc.).
     * @return string The operation prefix.
     *
     * @throws \InvalidArgumentException If the operation type is not supported.
     */
    public static function getOperationPrefix(string $operationType): string
    {
        if (!isset(self::OPERATION_PREFIXES[$operationType])) {
            throw new \InvalidArgumentException(
                sprintf('Unsupported operation type: %s', $operationType)
            );
        }

        return self::OPERATION_PREFIXES[$operationType];
    }

    /**
     * Gets all available operation prefixes.
     *
     * @since n.e.x.t
     *
     * @return array<string, string> Array of operation type => prefix mappings.
     */
    public static function getOperationPrefixes(): array
    {
        return self::OPERATION_PREFIXES;
    }
}
