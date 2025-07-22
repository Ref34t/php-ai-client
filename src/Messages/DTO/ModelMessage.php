<?php

declare(strict_types=1);

namespace WordPress\AiClient\Messages\DTO;

use WordPress\AiClient\Messages\Enums\MessageRoleEnum;

/**
 * Represents a message from the AI model
 *
 * This is a convenience class that automatically sets the role to MODEL.
 * Model messages contain the AI's responses.
 *
 * @since n.e.x.t
 */
class ModelMessage extends Message
{
    /**
     * Constructor
     *
     * @since n.e.x.t
     * @param MessagePart[] $parts The parts that make up this message
     */
    public function __construct(array $parts)
    {
        parent::__construct(MessageRoleEnum::model(), $parts);
    }

    /**
     * Create a model message from a simple text string
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