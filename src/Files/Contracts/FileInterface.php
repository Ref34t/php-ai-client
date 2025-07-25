<?php

declare(strict_types=1);

namespace WordPress\AiClient\Files\Contracts;

use WordPress\AiClient\Files\ValueObjects\MimeType;

/**
 * Interface for file representations in the AI client.
 *
 * This interface defines the common contract for various file types that can be
 * used as input or output in AI operations.
 *
 * @since n.e.x.t
 */
interface FileInterface
{
    /**
     * Gets the MIME type of the file as a string.
     *
     * @since n.e.x.t
     * @return string The MIME type string (e.g., 'image/png', 'audio/mp3').
     */
    public function getMimeType(): string;

    /**
     * Gets the MIME type object.
     *
     * @since n.e.x.t
     * @return MimeType The MIME type object.
     */
    public function getMimeTypeObject(): MimeType;

    /**
     * Checks if the file is a video.
     *
     * @since n.e.x.t
     *
     * @return bool True if the file is a video.
     */
    public function isVideo(): bool;

    /**
     * Checks if the file is an image.
     *
     * @since n.e.x.t
     *
     * @return bool True if the file is an image.
     */
    public function isImage(): bool;

    /**
     * Checks if the file is audio.
     *
     * @since n.e.x.t
     *
     * @return bool True if the file is audio.
     */
    public function isAudio(): bool;

    /**
     * Checks if the file is text.
     *
     * @since n.e.x.t
     *
     * @return bool True if the file is text.
     */
    public function isText(): bool;
}
