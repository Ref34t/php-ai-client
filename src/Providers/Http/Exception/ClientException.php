<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Http\Exception;

/**
 * Exception thrown for 4xx HTTP client errors.
 *
 * This represents errors where the client request was malformed,
 * unauthorized, forbidden, or otherwise invalid.
 *
 * @since n.e.x.t
 */
class ClientException extends RequestException
{
    /**
     * Creates a ClientException from a 400 Bad Request response.
     *
     * @since n.e.x.t
     *
     * @param string $errorDetail Details about what made the request bad.
     * @return self
     */
    public static function fromBadRequestResponse(string $errorDetail = 'Invalid request parameters'): self
    {
        $message = sprintf('Bad request (400): %s', $errorDetail);
        return new self($message);
    }
}
