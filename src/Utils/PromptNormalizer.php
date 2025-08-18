<?php

declare(strict_types=1);

namespace WordPress\AiClient\Utils;

use WordPress\AiClient\Messages\DTO\Message;
use WordPress\AiClient\Messages\DTO\MessagePart;
use WordPress\AiClient\Messages\DTO\UserMessage;

/**
 * Utility class for normalizing various prompt formats into standardized Message arrays.
 *
 * @since n.e.x.t
 */
class PromptNormalizer
{
    /**
     * Normalizes various prompt formats into a standardized Message array.
     *
     * @since n.e.x.t
     *
     * @param string|MessagePart|MessagePart[]|Message|Message[] $prompt The prompt content in various formats.
     * @return list<Message> Array of Message objects.
     *
     * @throws \InvalidArgumentException If the prompt format is invalid.
     */
    public static function normalize($prompt): array
    {
        // Handle string input
        if (is_string($prompt)) {
            return [new UserMessage([new MessagePart($prompt)])];
        }

        // Handle single MessagePart
        if ($prompt instanceof MessagePart) {
            return [new UserMessage([$prompt])];
        }

        // Handle single Message
        if ($prompt instanceof Message) {
            return [$prompt];
        }

        // Handle arrays
        if (is_array($prompt)) {
            // Empty array
            if (empty($prompt)) {
                throw new \InvalidArgumentException('Prompt array cannot be empty');
            }

            // Check first element to determine array type
            $firstElement = reset($prompt);

            // Array of Messages
            if ($firstElement instanceof Message) {
                // Validate all elements are Messages
                foreach ($prompt as $item) {
                    if (!$item instanceof Message) {
                        throw new \InvalidArgumentException('Array must contain only Message or MessagePart objects');
                    }
                }
                /** @var Message[] $messages */
                $messages = $prompt;
                return array_values($messages);
            }

            // Array of MessageParts
            if ($firstElement instanceof MessagePart) {
                // Validate all elements are MessageParts
                foreach ($prompt as $item) {
                    if (!$item instanceof MessagePart) {
                        throw new \InvalidArgumentException('Array must contain only Message or MessagePart objects');
                    }
                }
                // Convert each MessagePart to a UserMessage
                /** @var MessagePart[] $messageParts */
                $messageParts = $prompt;
                return array_values(array_map(fn(MessagePart $part) => new UserMessage([$part]), $messageParts));
            }

            // Invalid array content
            throw new \InvalidArgumentException('Array must contain only Message or MessagePart objects');
        }

        // Unsupported type
        throw new \InvalidArgumentException('Invalid prompt format provided');
    }

    /**
     * Normalizes embedding input into a standardized Message array.
     *
     * Handles both string arrays (common for embeddings) and other
     * message formats that can be processed by the main normalize method.
     *
     * @since n.e.x.t
     *
     * @param string[]|string|MessagePart|MessagePart[]|Message|Message[] $input The input data in various formats.
     * @return list<Message> Array of Message objects.
     *
     * @throws \InvalidArgumentException If the input format is invalid.
     */
    public static function normalizeEmbeddingInput($input): array
    {
        // Handle string array input (most common for embeddings)
        if (is_array($input) && !empty($input) && is_string($input[0])) {
            /** @var string[] $stringArray */
            $stringArray = $input;
            return self::normalizeStringArray($stringArray);
        }

        // For all other formats, use the main normalize method
        /** @var string|MessagePart|MessagePart[]|Message|Message[] $input */
        return self::normalize($input);
    }

    /**
     * Normalizes a string array into Message objects.
     *
     * Each string becomes a UserMessage with a single MessagePart.
     *
     * @since n.e.x.t
     *
     * @param string[] $stringArray Array of strings to normalize.
     * @return list<Message> Array of Message objects.
     *
     * @throws \InvalidArgumentException If the array contains non-string elements.
     */
    private static function normalizeStringArray(array $stringArray): array
    {
        // Validate all elements are strings
        foreach ($stringArray as $index => $item) {
            if (!is_string($item)) {
                throw new \InvalidArgumentException(
                    sprintf('Array element at index %d must be a string, %s given', $index, gettype($item))
                );
            }
        }

        // Convert each string to a UserMessage
        $messages = array_map(
            fn(string $text) => new UserMessage([new MessagePart($text)]),
            $stringArray
        );

        return array_values($messages);
    }

    /**
     * Validates that input is suitable for embedding generation.
     *
     * @since n.e.x.t
     *
     * @param mixed $input The input to validate.
     * @return bool True if the input is valid for embedding generation.
     */
    public static function isValidEmbeddingInput($input): bool
    {
        try {
            /** @phpstan-ignore-next-line */
            self::normalizeEmbeddingInput($input);
            return true;
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * Gets the number of input items that will be processed for embedding generation.
     *
     * Useful for understanding how many embeddings will be generated.
     *
     * @since n.e.x.t
     *
     * @param string[]|string|MessagePart|MessagePart[]|Message|Message[] $input The input data.
     * @return int The number of items that will be processed.
     *
     * @throws \InvalidArgumentException If the input format is invalid.
     */
    public static function getEmbeddingInputCount($input): int
    {
        $normalizedMessages = self::normalizeEmbeddingInput($input);
        return count($normalizedMessages);
    }
}
