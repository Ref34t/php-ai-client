<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Http\DTO;

use InvalidArgumentException;
use WordPress\AiClient\Common\AbstractDataTransferObject;

/**
 * Represents an HTTP response.
 *
 * This class encapsulates HTTP response data that has been converted
 * from PSR-7 responses by the HTTP transporter.
 *
 * @since n.e.x.t
 *
 * @phpstan-type ResponseArrayShape array{
 *     statusCode: int,
 *     headers: array<string, list<string>>,
 *     body?: string|null,
 *     reasonPhrase: string
 * }
 *
 * @extends AbstractDataTransferObject<ResponseArrayShape>
 */
class Response extends AbstractDataTransferObject
{
    public const KEY_STATUS_CODE = 'statusCode';
    public const KEY_HEADERS = 'headers';
    public const KEY_BODY = 'body';
    public const KEY_REASON_PHRASE = 'reasonPhrase';

    /**
     * @var int The HTTP status code.
     */
    protected int $statusCode;

    /**
     * @var array<string, list<string>> The response headers.
     */
    protected array $headers;

    /**
     * @var array<string, string> Map of lowercase header names to actual header names for fast lookup.
     */
    protected array $headersMap;

    /**
     * @var string|null The response body.
     */
    protected ?string $body;

    /**
     * @var string The reason phrase.
     */
    protected string $reasonPhrase;

    /**
     * Constructor.
     *
     * @since n.e.x.t
     *
     * @param int $statusCode The HTTP status code.
     * @param array<string, string|list<string>> $headers The response headers.
     * @param string|null $body The response body.
     * @param string $reasonPhrase The reason phrase.
     *
     * @throws InvalidArgumentException If the status code is invalid.
     */
    public function __construct(int $statusCode, array $headers, ?string $body = null, string $reasonPhrase = '')
    {
        if ($statusCode < 100 || $statusCode >= 600) {
            throw new InvalidArgumentException('Invalid HTTP status code: ' . $statusCode);
        }

        $this->statusCode = $statusCode;
        $this->headers = $this->normalizeHeaderValues($headers);
        $this->headersMap = $this->buildHeadersMap($this->headers);
        $this->body = $body;
        $this->reasonPhrase = $reasonPhrase;
    }

    /**
     * Gets the HTTP status code.
     *
     * @since n.e.x.t
     *
     * @return int The status code.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Gets the response headers.
     *
     * @since n.e.x.t
     *
     * @return array<string, list<string>> The headers.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Gets a specific header value.
     *
     * @since n.e.x.t
     *
     * @param string $name The header name (case-insensitive).
     * @return list<string>|null The header value(s) or null if not found.
     */
    public function getHeader(string $name): ?array
    {
        $lower = strtolower($name);
        if (!isset($this->headersMap[$lower])) {
            return null;
        }
        return $this->headers[$this->headersMap[$lower]];
    }

    /**
     * Gets the first value of a specific header.
     *
     * @since n.e.x.t
     *
     * @param string $name The header name (case-insensitive).
     * @return string|null The first header value or null if not found.
     */
    public function getHeaderLine(string $name): ?string
    {
        $values = $this->getHeader($name);
        return $values !== null ? implode(', ', $values) : null;
    }

    /**
     * Gets the response body.
     *
     * @since n.e.x.t
     *
     * @return string|null The body.
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Gets the reason phrase.
     *
     * @since n.e.x.t
     *
     * @return string The reason phrase.
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * Checks if the response indicates success.
     *
     * @since n.e.x.t
     *
     * @return bool True if status code is 2xx, false otherwise.
     */
    public function isSuccessful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    /**
     * Normalizes header values to ensure they are all arrays.
     *
     * @since n.e.x.t
     *
     * @param array<string, string|list<string>> $headers The headers to normalize.
     * @return array<string, list<string>> The normalized headers.
     */
    private function normalizeHeaderValues(array $headers): array
    {
        $normalized = [];
        foreach ($headers as $name => $value) {
            $normalized[$name] = is_array($value) ? array_values($value) : [$value];
        }
        return $normalized;
    }

    /**
     * Builds a map of lowercase header names to actual header names.
     *
     * @since n.e.x.t
     *
     * @param array<string, list<string>> $headers The headers.
     * @return array<string, string> The headers map.
     */
    private function buildHeadersMap(array $headers): array
    {
        $map = [];
        foreach (array_keys($headers) as $name) {
            $map[strtolower($name)] = $name;
        }
        return $map;
    }

    /**
     * Gets the response data as an array.
     *
     * Attempts to decode the body as JSON. Returns null if the body
     * is empty or not valid JSON.
     *
     * @since n.e.x.t
     *
     * @return array<string, mixed>|null The decoded data or null.
     */
    public function getData(): ?array
    {
        if ($this->body === null || $this->body === '') {
            return null;
        }

        $data = json_decode($this->body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        /** @var array<string, mixed>|null $data */
        return is_array($data) ? $data : null;
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
                self::KEY_STATUS_CODE => [
                    'type' => 'integer',
                    'minimum' => 100,
                    'maximum' => 599,
                    'description' => 'The HTTP status code.',
                ],
                self::KEY_HEADERS => [
                    'type' => 'object',
                    'additionalProperties' => [
                        'type' => 'array',
                        'items' => ['type' => 'string'],
                    ],
                    'description' => 'The response headers.',
                ],
                self::KEY_BODY => [
                    'type' => ['string', 'null'],
                    'description' => 'The response body.',
                ],
                self::KEY_REASON_PHRASE => [
                    'type' => 'string',
                    'description' => 'The reason phrase.',
                ],
            ],
            'required' => [self::KEY_STATUS_CODE, self::KEY_HEADERS, self::KEY_REASON_PHRASE],
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     *
     * @return ResponseArrayShape
     */
    public function toArray(): array
    {
        $data = [
            self::KEY_STATUS_CODE => $this->statusCode,
            self::KEY_HEADERS => $this->headers,
            self::KEY_REASON_PHRASE => $this->reasonPhrase,
        ];

        if ($this->body !== null) {
            $data[self::KEY_BODY] = $this->body;
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     */
    public static function fromArray(array $array): self
    {
        static::validateFromArrayData($array, [
            self::KEY_STATUS_CODE,
            self::KEY_HEADERS,
            self::KEY_REASON_PHRASE,
        ]);

        return new self(
            $array[self::KEY_STATUS_CODE],
            $array[self::KEY_HEADERS],
            $array[self::KEY_BODY] ?? null,
            $array[self::KEY_REASON_PHRASE]
        );
    }
}
