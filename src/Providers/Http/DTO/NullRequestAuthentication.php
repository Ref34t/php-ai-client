<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Http\DTO;

use WordPress\AiClient\Common\AbstractDataTransferObject;
use WordPress\AiClient\Providers\Http\Contracts\RequestAuthenticationInterface;

/**
 * Class for an empty HTTP request authentication.
 *
 * @since n.e.x.t
 *
 * @phpstan-type NullRequestAuthenticationArrayShape array{}
 *
 * @extends AbstractDataTransferObject<NullRequestAuthenticationArrayShape>
 */
class NullRequestAuthentication extends AbstractDataTransferObject implements RequestAuthenticationInterface
{
    /**
     * @inheritDoc
     */
    public function authenticateRequest(Request $request): Request
    {
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $array): self
    {
        return new self();
    }

    /**
     * @inheritDoc
     */
    public static function getJsonSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [],
            'required' => [],
        ];
    }
}
