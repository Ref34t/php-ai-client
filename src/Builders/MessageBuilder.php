<?php

declare(strict_types=1);

namespace WordPress\AiClient\Builders;

use InvalidArgumentException;
use WordPress\AiClient\Files\DTO\File;
use WordPress\AiClient\Messages\DTO\Message;
use WordPress\AiClient\Messages\DTO\MessagePart;
use WordPress\AiClient\Messages\Enums\MessageRoleEnum;
use WordPress\AiClient\Tools\DTO\FunctionCall;
use WordPress\AiClient\Tools\DTO\FunctionResponse;

/**
 * Fluent builder for constructing AI messages.
 *
 * This class provides a fluent interface for building messages with various
 * content types including text, files, function calls, and function responses.
 * It automatically handles role-specific validation and creates the appropriate
 * message subclass based on the configured role.
 *
 * @since n.e.x.t
 */
class MessageBuilder
{
    /**
     * @var MessageRoleEnum|null The role of the message sender.
     */
    protected ?MessageRoleEnum $role = null;

    /**
     * @var list<MessagePart> The parts that make up the message.
     */
    protected array $parts = [];

    /**
     * Constructor.
     *
     * @since n.e.x.t
     *
     * @param string|null $text Optional initial text content.
     * @param MessageRoleEnum|null $role Optional role.
     */
    public function __construct(?string $text = null, ?MessageRoleEnum $role = null)
    {
        $this->role = $role;

        if ($text !== null) {
            $this->withText($text);
        }
    }

    /**
     * Sets the role of the message sender.
     *
     * @since n.e.x.t
     *
     * @param MessageRoleEnum $role The role to set.
     * @return self
     */
    public function usingRole(MessageRoleEnum $role): self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Sets the role to user.
     *
     * @since n.e.x.t
     *
     * @return self
     */
    public function usingUserRole(): self
    {
        return $this->usingRole(MessageRoleEnum::user());
    }

    /**
     * Sets the role to model.
     *
     * @since n.e.x.t
     *
     * @return self
     */
    public function usingModelRole(): self
    {
        return $this->usingRole(MessageRoleEnum::model());
    }

    /**
     * Adds text content to the message.
     *
     * @since n.e.x.t
     *
     * @param string $text The text to add.
     * @return self
     * @throws InvalidArgumentException If the text is empty.
     */
    public function withText(string $text): self
    {
        if (trim($text) === '') {
            throw new InvalidArgumentException('Text content cannot be empty.');
        }

        $this->parts[] = new MessagePart($text);
        return $this;
    }

    /**
     * Adds a file to the message.
     *
     * Accepts:
     * - File object
     * - URL string (remote file)
     * - Base64-encoded data string
     * - Data URI string (data:mime/type;base64,data)
     * - Local file path string
     *
     * @since n.e.x.t
     *
     * @param string|File $file The file to add.
     * @param string|null $mimeType Optional MIME type (ignored if File object provided).
     * @return self
     * @throws InvalidArgumentException If the file is invalid.
     */
    public function withFile($file, ?string $mimeType = null): self
    {
        $file = $file instanceof File ? $file : new File($file, $mimeType);
        $this->parts[] = new MessagePart($file);
        return $this;
    }

    /**
     * Adds a function call to the message.
     *
     * @since n.e.x.t
     *
     * @param FunctionCall $functionCall The function call to add.
     * @return self
     */
    public function withFunctionCall(FunctionCall $functionCall): self
    {
        $this->parts[] = new MessagePart($functionCall);
        return $this;
    }

    /**
     * Adds a function response to the message.
     *
     * @since n.e.x.t
     *
     * @param FunctionResponse $functionResponse The function response to add.
     * @return self
     */
    public function withFunctionResponse(FunctionResponse $functionResponse): self
    {
        $this->parts[] = new MessagePart($functionResponse);
        return $this;
    }

    /**
     * Adds multiple message parts to the message.
     *
     * @since n.e.x.t
     *
     * @param MessagePart ...$parts The message parts to add.
     * @return self
     */
    public function withMessageParts(MessagePart ...$parts): self
    {
        foreach ($parts as $part) {
            $this->parts[] = $part;
        }

        return $this;
    }

    /**
     * Validates that the message is ready to be built.
     *
     * @since n.e.x.t
     *
     * @return void
     * @throws InvalidArgumentException If validation fails.
     */
    private function validateForBuild(): void
    {
        if (empty($this->parts)) {
            throw new InvalidArgumentException(
                'Cannot build an empty message. Add content using withText() or similar methods.'
            );
        }

        if ($this->role === null) {
            throw new InvalidArgumentException(
                'Cannot build a message with no role. Set a role using usingRole() or similar methods.'
            );
        }

        // Validate parts are appropriate for the role
        foreach ($this->parts as $part) {
            if ($this->role->isUser() && $part->getType()->isFunctionCall()) {
                throw new InvalidArgumentException(
                    'User messages cannot contain function calls.'
                );
            }

            if ($this->role->isModel() && $part->getType()->isFunctionResponse()) {
                throw new InvalidArgumentException(
                    'Model messages cannot contain function responses.'
                );
            }
        }
    }

    /**
     * Builds and returns the Message object.
     *
     * @since n.e.x.t
     *
     * @return Message The built message.
     * @throws InvalidArgumentException If the message validation fails.
     */
    public function get(): Message
    {
        $this->validateForBuild();

        // At this point, we've validated that $this->role is not null
        /** @var MessageRoleEnum $role */
        $role = $this->role;

        return new Message($role, $this->parts);
    }
}
