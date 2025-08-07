<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Contracts;

use WordPress\AiClient\Common\Contracts\WithJsonSchemaInterface;
use WordPress\AiClient\Http\DTO\Request;

/**
 * Interface for authentication implementations.
 *
 * Provides a contract for different authentication mechanisms
 * to modify HTTP requests with appropriate credentials.
 *
 * @since n.e.x.t
 */
interface AuthenticationInterface extends WithJsonSchemaInterface
{
    /**
     * Authenticates a request.
     *
     * @since n.e.x.t
     *
     * @param Request $request The request to authenticate.
     * @return Request The authenticated request.
     */
    public function authenticate(Request $request): Request;
}
