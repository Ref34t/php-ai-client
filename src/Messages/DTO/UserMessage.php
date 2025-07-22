<?php

declare(strict_types=1);

namespace WordPress\AiClient\Messages\DTO;

use WordPress\AiClient\Messages\Enums\MessageRoleEnum;

/**
 * Represents a message from a user
 *
 * This is a convenience class that automatically sets the role to USER.
 *
 * @since n.e.x.t
 */
class UserMessage extends Message
{
    /**
     * Constructor
     *
     * @since n.e.x.t
     * @param MessagePart[] $parts The parts that make up this message
     */
    public function __construct(array $parts)
    {
        parent::__construct(MessageRoleEnum::user(), $parts);
    }

    /**
     * Create a user message from a simple text string
     *
     * @since n.e.x.t
     * @param string $text The text content
     * @return self
     */
    public static function fromText(string $text): self
    {
        return new self([MessagePart::text($text)]);
    }
}