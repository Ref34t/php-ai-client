<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Enums;

use WordPress\AiClient\Common\AbstractEnum;

/**
 * Enum for tool types
 *
 * @since n.e.x.t
 * @method static self functionDeclarations() Create an instance for FUNCTION_DECLARATIONS type
 * @method static self webSearch() Create an instance for WEB_SEARCH type
 * @method bool isFunctionDeclarations() Check if the type is FUNCTION_DECLARATIONS
 * @method bool isWebSearch() Check if the type is WEB_SEARCH
 */
class ToolTypeEnum extends AbstractEnum
{
    /**
     * Function declarations tool type
     */
    public const FUNCTION_DECLARATIONS = 'function_declarations';

    /**
     * Web search tool type
     */
    public const WEB_SEARCH = 'web_search';
}
