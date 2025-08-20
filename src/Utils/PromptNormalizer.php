<?php

declare(strict_types=1);

namespace WordPress\AiClient\Utils;

use WordPress\AiClient\Messages\DTO\Message;
use WordPress\AiClient\Messages\DTO\MessagePart;
use WordPress\AiClient\Messages\DTO\UserMessage;

/**
 * Utility class for normalizing various prompt formats into a standardized Message.
 *
 * @since n.e.x.t
 *
 * @phpstan-import-type MessageArrayShape from Message
 */
class PromptNormalizer
{
    /**
     * Checks if the given value is a list of Message objects.
     *
     * @since n.e.x.t
     *
     * @param mixed $value The value to check.
     * @return bool True if the value is a list of Messages.
     *
     * @phpstan-assert-if-true list<Message> $value
     */
    public static function isMessagesList($value): bool
    {
        if (!is_array($value) || empty($value) || !array_is_list($value)) {
            return false;
        }

        // Check that every element is a Message
        foreach ($value as $item) {
            if (!($item instanceof Message)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Normalizes various prompt formats into a standardized Message.
     *
     * Supports:
     * - String: converted to UserMessage with single MessagePart
     * - Structured array: {'role': 'system', 'parts': [...]} format
     * - Message: returned as-is
     * - Array of strings/MessageParts: converted to UserMessage with multiple parts
     *
     * @since n.e.x.t
     *
     * @param mixed $prompt The prompt content in various formats.
     * @return Message The normalized message.
     *
     * @throws \InvalidArgumentException If the prompt format is invalid.
     */
    public static function normalize($prompt): Message
    {
        // Already a Message
        if ($prompt instanceof Message) {
            return $prompt;
        }

        // Simple string
        if (is_string($prompt)) {
            return new UserMessage([new MessagePart($prompt)]);
        }

        // Structured message array with role and parts
        if (is_array($prompt) && isset($prompt[Message::KEY_ROLE]) && isset($prompt[Message::KEY_PARTS])) {
            /** @var MessageArrayShape $prompt */
            return Message::fromArray($prompt);
        }

        // Array of strings/MessageParts to combine into a single UserMessage
        if (is_array($prompt)) {
            if (empty($prompt)) {
                throw new \InvalidArgumentException('Prompt array cannot be empty');
            }

            $parts = [];
            foreach ($prompt as $item) {
                if (is_string($item)) {
                    $parts[] = new MessagePart($item);
                } elseif ($item instanceof MessagePart) {
                    $parts[] = $item;
                } else {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Array items must be strings or MessagePart objects, got %s',
                            is_object($item) ? get_class($item) : gettype($item)
                        )
                    );
                }
            }

            return new UserMessage($parts);
        }

        // Invalid format
        throw new \InvalidArgumentException(
            sprintf(
                'Invalid prompt format: expected string, Message, structured array, ' .
                'or array of strings/MessageParts, got %s',
                is_object($prompt) ? get_class($prompt) : gettype($prompt)
            )
        );
    }
}
