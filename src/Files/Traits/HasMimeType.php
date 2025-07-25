<?php

declare(strict_types=1);

namespace WordPress\AiClient\Files\Traits;

use WordPress\AiClient\Files\ValueObjects\MimeType;

/**
 * Provides MIME type functionality for file objects.
 *
 * This trait can be used by any class that needs to store and retrieve
 * a MIME type property.
 *
 * @since n.e.x.t
 */
trait HasMimeType
{
    /**
     * The MIME type of the file.
     *
     * @var MimeType
     */
    protected MimeType $mimeType;

    /**
     * Gets the MIME type of the file as a string.
     *
     * @since n.e.x.t
     *
     * @return string The MIME type string value.
     */
    public function getMimeType(): string
    {
        return (string) $this->mimeType;
    }

    /**
     * Gets the MIME type object.
     *
     * @since n.e.x.t
     *
     * @return MimeType The MIME type object.
     */
    public function getMimeTypeObject(): MimeType
    {
        return $this->mimeType;
    }

    /**
     * Checks if the file is a video.
     *
     * @since n.e.x.t
     *
     * @return bool True if the file is a video.
     */
    public function isVideo(): bool
    {
        return $this->mimeType->isVideo();
    }

    /**
     * Checks if the file is an image.
     *
     * @since n.e.x.t
     *
     * @return bool True if the file is an image.
     */
    public function isImage(): bool
    {
        return $this->mimeType->isImage();
    }

    /**
     * Checks if the file is audio.
     *
     * @since n.e.x.t
     *
     * @return bool True if the file is audio.
     */
    public function isAudio(): bool
    {
        return $this->mimeType->isAudio();
    }

    /**
     * Checks if the file is text.
     *
     * @since n.e.x.t
     *
     * @return bool True if the file is text.
     */
    public function isText(): bool
    {
        return $this->mimeType->isText();
    }

    /**
     * Gets the JSON schema for the MIME type property.
     *
     * @since n.e.x.t
     *
     * @return array{type: string, description: string, pattern: string} The JSON schema for the mimeType property.
     */
    protected static function getMimeTypePropertySchema(): array
    {
        return [
            'type' => 'string',
            'description' => 'The MIME type of the file.',
            'pattern' => '^[a-zA-Z0-9][a-zA-Z0-9!#$&\\-\\^_+.]*\\/[a-zA-Z0-9][a-zA-Z0-9!#$&\\-\\^_+.]*$',
        ];
    }
}
