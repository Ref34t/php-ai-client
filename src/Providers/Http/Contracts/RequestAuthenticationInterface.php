<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Http\Contracts;

use WordPress\AiClient\Providers\Http\DTO\Request;

/**
 * Interface for HTTP request authentication.
 *
 * @since 1.0.0
 */
interface RequestAuthenticationInterface
{
    /**
     * Authenticates an HTTP request.
     *
     * @since 1.0.0
     *
     * @param Request $request The request to authenticate.
     * @return void
     */
    public function authenticate(Request $request): void;

    /**
     * Returns the JSON schema for this authentication.
     *
     * @since 1.0.0
     *
     * @return array<string, mixed> The JSON schema.
     */
    public static function getJsonSchema(): array;
}
