<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Enums;

use WordPress\AiClient\Common\AbstractEnum;

/**
 * Enum for provider types
 *
 * @method static self cloud() Create an instance for CLOUD type
 * @method static self server() Create an instance for SERVER type
 * @method static self client() Create an instance for CLIENT type
 * @method bool isCloud() Check if the type is CLOUD
 * @method bool isServer() Check if the type is SERVER
 * @method bool isClient() Check if the type is CLIENT
 */
class ProviderTypeEnum extends AbstractEnum
{
    /**
     * Cloud-based AI provider (e.g., OpenAI, Google, Anthropic)
     */
    public const CLOUD = 'cloud';

    /**
     * Server-side AI provider (e.g., self-hosted models)
     */
    public const SERVER = 'server';

    /**
     * Client-side AI provider (e.g., browser-based models)
     */
    public const CLIENT = 'client';
}
