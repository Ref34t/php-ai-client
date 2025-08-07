<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Models\Contracts;

use WordPress\AiClient\Providers\Contracts\AuthenticationInterface;

/**
 * Interface for models that support authentication.
 *
 * Models implementing this interface can have authentication
 * mechanisms configured for API requests.
 *
 * @since n.e.x.t
 */
interface WithAuthenticationInterface
{
    /**
     * Sets the authentication mechanism.
     *
     * @since n.e.x.t
     *
     * @param AuthenticationInterface $authentication The authentication implementation.
     * @return void
     */
    public function setAuthentication(AuthenticationInterface $authentication): void;

    /**
     * Gets the authentication mechanism.
     *
     * @since n.e.x.t
     *
     * @return AuthenticationInterface The authentication implementation.
     */
    public function getAuthentication(): AuthenticationInterface;
}
