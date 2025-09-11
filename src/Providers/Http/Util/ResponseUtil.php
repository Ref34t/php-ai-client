<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Http\Util;

use WordPress\AiClient\Providers\Http\DTO\Response;
use WordPress\AiClient\Providers\Http\Exception\ClientException;
use WordPress\AiClient\Providers\Http\Exception\ResponseException;

/**
 * Class with static utility methods to process HTTP responses.
 *
 * @since 0.1.0
 */
class ResponseUtil
{
    /**
     * Throws a response exception if the given response is not successful.
     *
     * This method checks the HTTP status code of the response and throws
     * a ResponseException if the status code indicates an error (i.e., not in the
     * 2xx range). It also attempts to extract a more detailed error message from
     * the response body if available.
     *
     * @since 0.1.0
     *
     * @param Response $response The HTTP response to check.
     * @throws ResponseException If the response is not successful.
     */
    public static function throwIfNotSuccessful(Response $response): void
    {
        if ($response->isSuccessful()) {
            return;
        }

        // Check for 400 Bad Request responses indicating invalid request data
        if ($response->getStatusCode() === 400) {
            $body = (string) $response->getBody();
            $errorDetail = $body ? substr($body, 0, 200) : 'Invalid request parameters';
            throw ClientException::fromBadRequestResponse($errorDetail);
        }

        throw ResponseException::fromBadResponse($response);
    }
}
