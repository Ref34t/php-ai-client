<?php

declare(strict_types=1);

namespace WordPress\AiClient\Messages\Enums;

use WordPress\AiClient\Common\AbstractEnum;

/**
 * Enum for message roles in AI conversations
 *
 * @method static self user() Create an instance for USER role
 * @method static self model() Create an instance for MODEL role
 * @method static self system() Create an instance for SYSTEM role
 * @method bool isUser() Check if the role is USER
 * @method bool isModel() Check if the role is MODEL
 * @method bool isSystem() Check if the role is SYSTEM
 */
class MessageRoleEnum extends AbstractEnum
{
    /**
     * User role - messages from the user
     */
    public const USER = 'user';

    /**
     * Model role - messages from the AI model
     */
    public const MODEL = 'model';

    /**
     * System role - system instructions
     */
    public const SYSTEM = 'system';
}
