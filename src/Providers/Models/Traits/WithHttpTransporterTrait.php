<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Models\Traits;

use RuntimeException;
use WordPress\AiClient\Providers\Contracts\HttpTransporterInterface;

/**
 * Trait for a class that implements WithHttpTransporterInterface.
 *
 * @since n.e.x.t
 */
trait WithHttpTransporterTrait
{
    private ?HttpTransporterInterface $httpTransporter = null;

    public function setHttpTransporter(HttpTransporterInterface $httpTransporter): void
    {
        $this->httpTransporter = $httpTransporter;
    }

    public function getHttpTransporter(): HttpTransporterInterface
    {
        if ($this->httpTransporter === null) {
            throw new RuntimeException(
                'HttpTransporterInterface instance not set. Make sure you use the AiClient class for all requests.'
            );
        }
        return $this->httpTransporter;
    }
}
