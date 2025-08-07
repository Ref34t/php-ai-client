<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Models\Contracts;

use WordPress\AiClient\Http\Contracts\HttpTransporterInterface;

/**
 * Interface for models that require HTTP transport capabilities.
 *
 * Models implementing this interface can send HTTP requests
 * to provider APIs using the configured HTTP transporter.
 *
 * @since n.e.x.t
 */
interface WithHttpTransporterInterface
{
    /**
     * Sets the HTTP transporter.
     *
     * @since n.e.x.t
     *
     * @param HttpTransporterInterface $transporter The HTTP transporter.
     * @return void
     */
    public function setHttpTransporter(HttpTransporterInterface $transporter): void;

    /**
     * Gets the HTTP transporter.
     *
     * @since n.e.x.t
     *
     * @return HttpTransporterInterface The HTTP transporter.
     */
    public function getHttpTransporter(): HttpTransporterInterface;
}
