<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Http\DTO;

use WordPress\AiClient\Common\AbstractDataTransferObject;
use WordPress\AiClient\Common\Exception\InvalidArgumentException;

/**
 * Represents HTTP request options.
 *
 * This class encapsulates transport-level request configuration options
 * such as timeout and redirection settings.
 *
 * @since n.e.x.t
 *
 * @phpstan-type RequestOptionsArrayShape array{
 *     timeout?: int|null,
 *     max_redirects?: int|null
 * }
 *
 * @extends AbstractDataTransferObject<RequestOptionsArrayShape>
 */
class RequestOptions extends AbstractDataTransferObject
{
    public const KEY_TIMEOUT = 'timeout';
    public const KEY_MAX_REDIRECTS = 'max_redirects';

    /**
     * Default timeout in seconds.
     */
    public const DEFAULT_TIMEOUT = 30;

    /**
     * Default maximum number of redirects.
     */
    public const DEFAULT_MAX_REDIRECTS = 5;

    /**
     * Maximum allowed timeout in seconds (1 hour).
     */
    public const MAX_TIMEOUT = 3600;

    /**
     * Maximum allowed redirects.
     */
    public const MAX_REDIRECTS = 100;

    /**
     * @var int|null The request timeout in seconds.
     */
    protected ?int $timeout = null;

    /**
     * @var int|null The maximum number of redirects to follow.
     */
    protected ?int $max_redirects = null;

    /**
     * Constructor.
     *
     * @since n.e.x.t
     *
     * @param int|null $timeout The request timeout in seconds.
     * @param int|null $max_redirects The maximum number of redirects to follow.
     *
     * @throws InvalidArgumentException If timeout or max_redirects is invalid.
     */
    public function __construct(?int $timeout = null, ?int $max_redirects = null)
    {
        if ($timeout !== null && ($timeout < 0 || $timeout > self::MAX_TIMEOUT)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Timeout must be between 0 and %d seconds.',
                    self::MAX_TIMEOUT
                )
            );
        }

        if ($max_redirects !== null && ($max_redirects < 0 || $max_redirects > self::MAX_REDIRECTS)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Max redirects must be between 0 and %d.',
                    self::MAX_REDIRECTS
                )
            );
        }

        $this->timeout = $timeout;
        $this->max_redirects = $max_redirects;
    }

    /**
     * Gets the request timeout in seconds.
     *
     * @since n.e.x.t
     *
     * @return int|null The timeout in seconds, or null if not set.
     */
    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    /**
     * Gets the maximum number of redirects to follow.
     *
     * @since n.e.x.t
     *
     * @return int|null The maximum number of redirects, or null if not set.
     */
    public function getMaxRedirects(): ?int
    {
        return $this->max_redirects;
    }

    /**
     * Returns a new instance with the specified timeout.
     *
     * @since n.e.x.t
     *
     * @param int|null $timeout The timeout in seconds.
     * @return self A new instance with the timeout.
     *
     * @throws InvalidArgumentException If timeout is invalid.
     */
    public function withTimeout(?int $timeout): self
    {
        if ($timeout !== null && ($timeout < 0 || $timeout > self::MAX_TIMEOUT)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Timeout must be between 0 and %d seconds.',
                    self::MAX_TIMEOUT
                )
            );
        }

        $new = clone $this;
        $new->timeout = $timeout;
        return $new;
    }

    /**
     * Returns a new instance with the specified max redirects.
     *
     * @since n.e.x.t
     *
     * @param int|null $maxRedirects The maximum number of redirects.
     * @return self A new instance with the max redirects.
     *
     * @throws InvalidArgumentException If maxRedirects is invalid.
     */
    public function withMaxRedirects(?int $maxRedirects): self
    {
        if ($maxRedirects !== null && ($maxRedirects < 0 || $maxRedirects > self::MAX_REDIRECTS)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Max redirects must be between 0 and %d.',
                    self::MAX_REDIRECTS
                )
            );
        }

        $new = clone $this;
        $new->max_redirects = $maxRedirects;
        return $new;
    }

    /**
     * Checks if any options are set.
     *
     * @since n.e.x.t
     *
     * @return bool True if any options are set, false otherwise.
     */
    public function hasOptions(): bool
    {
        return $this->timeout !== null || $this->max_redirects !== null;
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
                self::KEY_TIMEOUT => [
                    'type' => ['integer', 'null'],
                    'minimum' => 0,
                    'description' => 'The request timeout in seconds.',
                ],
                self::KEY_MAX_REDIRECTS => [
                    'type' => ['integer', 'null'],
                    'minimum' => 0,
                    'description' => 'The maximum number of redirects to follow.',
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     *
     * @return RequestOptionsArrayShape
     */
    public function toArray(): array
    {
        $array = [];

        if ($this->timeout !== null) {
            $array[self::KEY_TIMEOUT] = $this->timeout;
        }

        if ($this->max_redirects !== null) {
            $array[self::KEY_MAX_REDIRECTS] = $this->max_redirects;
        }

        return $array;
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     *
     * @param RequestOptionsArrayShape $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            $array[self::KEY_TIMEOUT] ?? null,
            $array[self::KEY_MAX_REDIRECTS] ?? null
        );
    }

    /**
     * Creates a RequestOptions instance with default values.
     *
     * @since n.e.x.t
     *
     * @return self A new RequestOptions instance with default values.
     */
    public static function defaults(): self
    {
        return new self(
            self::DEFAULT_TIMEOUT,
            self::DEFAULT_MAX_REDIRECTS
        );
    }
}
