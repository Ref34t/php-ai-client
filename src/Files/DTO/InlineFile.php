<?php

declare(strict_types=1);

namespace WordPress\AiClient\Files\DTO;

use WordPress\AiClient\Common\Contracts\WithJsonSchemaInterface;
use WordPress\AiClient\Files\Contracts\FileInterface;
use WordPress\AiClient\Files\Traits\HasMimeType;
use WordPress\AiClient\Files\ValueObjects\MimeType;

/**
 * Represents a file with inline base64-encoded data.
 *
 * This DTO is used for files that are embedded directly in the request as base64 data,
 * commonly used for small files or when direct data transfer is preferred.
 *
 * @since n.e.x.t
 */
class InlineFile implements FileInterface, WithJsonSchemaInterface
{
    use HasMimeType;

    /**
     * @var string The plain base64-encoded file data (without data URI prefix).
     */
    private string $base64Data;

    /**
     * Constructor.
     *
     * @since n.e.x.t
     *
     * @param string $base64Data The base64-encoded file data.
     * @param MimeType|string|null $mimeType The MIME type of the file.
     */
    public function __construct(string $base64Data, $mimeType = null)
    {
        // RFC 2397: dataurl := "data:" [ mediatype ] ";base64," data
        $dataUriPattern = '/^data:(?:([a-zA-Z0-9][a-zA-Z0-9!#$&\-\^_+.]*\/[a-zA-Z0-9][a-zA-Z0-9!#$&\-\^_+.]*'
            . '(?:;[a-zA-Z0-9\-]+=[a-zA-Z0-9\-]+)*)?;)?base64,([A-Za-z0-9+\/]*={0,2})$/';

        // Check if this is a data URI
        if (preg_match($dataUriPattern, $base64Data, $matches)) {
            $this->base64Data = $matches[2];
            $this->mimeType = $this->parseMimeType($mimeType, empty($matches[1]) ? null : $matches[1]);
            return;
        }

        // Check if this is plain base64 data
        if (preg_match('/^[A-Za-z0-9+\/]*={0,2}$/', $base64Data)) {
            if ($mimeType === null) {
                throw new \InvalidArgumentException(
                    'MIME type is required when providing plain base64 data without data URI format.'
                );
            }
            $this->base64Data = $base64Data;
            $this->mimeType = $this->parseMimeType($mimeType);
            return;
        }

        throw new \InvalidArgumentException(
            'Invalid base64 data provided. Expected either data URI format '
            . '(data:[mimeType];base64,[data]) or plain base64 string.'
        );
    }

    /**
     * Gets the base64-encoded data.
     *
     * @since n.e.x.t
     *
     * @return string The plain base64-encoded data (without data URI prefix).
     */
    public function getBase64Data(): string
    {
        return $this->base64Data;
    }

    /**
     * Gets the data as a data URL.
     *
     * @since n.e.x.t
     *
     * @return string The data URL in format: data:[mimeType];base64,[data].
     */
    public function getDataUrl(): string
    {
        return sprintf('data:%s;base64,%s', (string) $this->mimeType, $this->base64Data);
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     */
    public static function getJsonSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'mimeType' => self::getMimeTypePropertySchema(),
                'base64Data' => [
                    'type' => 'string',
                    'description' => 'The base64-encoded file data.',
                ],
            ],
            'required' => ['mimeType', 'base64Data'],
        ];
    }

    /**
     * Parses and validates the MIME type.
     *
     * @since n.e.x.t
     *
     * @param MimeType|string|null $providedMimeType The explicitly provided MIME type.
     * @param string|null $extractedMimeType The MIME type extracted from data URI.
     * @return MimeType The parsed MIME type.
     */
    private function parseMimeType($providedMimeType, ?string $extractedMimeType = null): MimeType
    {
        // Prefer explicitly provided MIME type
        if ($providedMimeType instanceof MimeType) {
            return $providedMimeType;
        }

        if ($providedMimeType !== null) {
            return new MimeType($providedMimeType);
        }

        // Use extracted MIME type from data URI
        if ($extractedMimeType !== null) {
            return new MimeType($extractedMimeType);
        }

        // RFC 2397: if mediatype is omitted in data URI, defaults to text/plain
        return new MimeType('text/plain');
    }
}
