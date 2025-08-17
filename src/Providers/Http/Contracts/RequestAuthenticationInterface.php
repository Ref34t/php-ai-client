<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Http\Contracts;

use WordPress\AiClient\Common\Contracts\WithArrayTransformationInterface;
use WordPress\AiClient\Common\Contracts\WithJsonSchemaInterface;
use WordPress\AiClient\Providers\Http\DTO\Request;

/**
 * Interface for HTTP request authentication.
 *
 * @since n.e.x.t
 */
interface RequestAuthenticationInterface extends
    WithArrayTransformationInterface,
    WithJsonSchemaInterface
{
    /**
     * Authenticates an HTTP request.
     *
     * @since n.e.x.t
     *
     * @param Request $request The request to authenticate.
     * @return Request The authenticated request.
     */
    public function authenticateRequest(Request $request): Request;
}
