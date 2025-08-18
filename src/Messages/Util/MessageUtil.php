<?php

declare(strict_types=1);

namespace WordPress\AiClient\Messages\Util;

use WordPress\AiClient\Messages\DTO\Message;
use WordPress\AiClient\Messages\DTO\MessagePart;
use WordPress\AiClient\Messages\Enums\MessageRoleEnum;

/**
 * Class with static utility methods to process messages.
 *
 * @since n.e.x.t
 *
 * @phpstan-import-type MessageArrayShape from Message
 * @phpstan-import-type MessagePartArrayShape from MessagePart
 */
class MessageUtil
{
    /**
     * Parses a message from various input formats.
     *
     * This method can handle:
     * - A Message instance.
     * - An associative array representing a message with 'role' and 'parts'.
     * - One or more strings or DTOs related to message parts, to be parsed into MessagePart instances.
     * - One or more associative arrays representing message parts, to be parsed into MessagePart instances.
     *
     * @since n.e.x.t
     *
     * @param mixed $input The input to parse into a Message.
     * @return Message The parsed Message instance.
     */
    public static function parseMessageFromInput($input): Message
    {
        // If it's already a Message instance, return it as is.
        if ($input instanceof Message) {
            return $input;
        }

        // If it's an array of message data, parse it into a Message instance.
        if (is_array($input) && isset($input[Message::KEY_ROLE]) && isset($input[Message::KEY_PARTS])) {
            /** @var MessageArrayShape $input */
            return Message::fromArray($input);
        }

        // Otherwise, it must be some form of input that can be converted to message parts, either one or multiple.
        if (!is_array($input) || !array_is_list($input)) {
            $input = [$input];
        }
        $parts = array_map(
            static function ($partInput) {
                if ($partInput instanceof MessagePart) {
                    return $partInput;
                }
                if (is_string($partInput)) {
                    return new MessagePart($partInput);
                }
                if (is_array($partInput)) {
                    /** @var MessagePartArrayShape $partInput */
                    return MessagePart::fromArray($partInput);
                }
                return new MessagePart($partInput);
            },
            $input
        );

        /*
         * Assume it's a user message, since that's always the case for a single message input.
         * For multiple messages, the more complex shape of entire messages data would need to be passed.
         */
        return new Message(
            MessageRoleEnum::user(),
            $parts
        );
    }

    /**
     * Parses multiple messages from input.
     *
     * This method can handle:
     * - An array of Message instances.
     * - An array of associative arrays representing messages with 'role' and 'parts'.
     * - A single message input, which will be parsed into a single Message instance.
     *
     * @since n.e.x.t
     *
     * @param mixed $input The input to parse into messages.
     * @return Message[] An array of parsed Message instances.
     */
    public static function parseMessagesFromInput($input): array
    {
        // Either it's message data, in case of multiple messages.
        if (
            is_array($input) &&
            array_is_list($input) &&
            isset($input[0]) &&
            (
                $input[0] instanceof Message ||
                (
                    is_array($input[0]) &&
                    isset($input[0][Message::KEY_ROLE]) &&
                    isset($input[0][Message::KEY_PARTS])
                )
            )
        ) {
            return array_map(
                [MessageUtil::class, 'parseMessageFromInput'],
                $input
            );
        }

        // Or it's simply input for a single message.
        return [
            MessageUtil::parseMessageFromInput($input),
        ];
    }
}
