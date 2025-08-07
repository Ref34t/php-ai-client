<?php

declare(strict_types=1);

namespace WordPress\AiClient\Http\DTO;

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
 *     headers: array<string, string|list<string>>,
 *     body: string,
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
     * @var array<string, string|list<string>> The response headers.
     */
    protected array $headers;

    /**
     * @var string The response body.
     */
    protected string $body;

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
     * @param string $body The response body.
     * @param string $reasonPhrase The reason phrase.
     *
     * @throws InvalidArgumentException If the status code is invalid.
     */
    public function __construct(int $statusCode, array $headers, string $body, string $reasonPhrase = '')
    {
        if ($statusCode < 100 || $statusCode >= 600) {
            throw new InvalidArgumentException('Invalid HTTP status code: ' . $statusCode);
        }

        $this->statusCode = $statusCode;
        $this->headers = $headers;
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
     * @return array<string, string|list<string>> The headers.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Gets the response body.
     *
     * @since n.e.x.t
     *
     * @return string The body.
     */
    public function getBody(): string
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
                        'oneOf' => [
                            ['type' => 'string'],
                            [
                                'type' => 'array',
                                'items' => ['type' => 'string'],
                            ],
                        ],
                    ],
                    'description' => 'The response headers.',
                ],
                self::KEY_BODY => [
                    'type' => 'string',
                    'description' => 'The response body.',
                ],
                self::KEY_REASON_PHRASE => [
                    'type' => 'string',
                    'description' => 'The reason phrase.',
                ],
            ],
            'required' => [self::KEY_STATUS_CODE, self::KEY_HEADERS, self::KEY_BODY, self::KEY_REASON_PHRASE],
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
        return [
            self::KEY_STATUS_CODE => $this->statusCode,
            self::KEY_HEADERS => $this->headers,
            self::KEY_BODY => $this->body,
            self::KEY_REASON_PHRASE => $this->reasonPhrase,
        ];
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
            self::KEY_BODY,
            self::KEY_REASON_PHRASE,
        ]);

        return new self(
            $array[self::KEY_STATUS_CODE],
            $array[self::KEY_HEADERS],
            $array[self::KEY_BODY],
            $array[self::KEY_REASON_PHRASE]
        );
    }
}
