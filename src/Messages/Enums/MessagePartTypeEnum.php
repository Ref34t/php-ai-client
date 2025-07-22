<?php

declare(strict_types=1);

namespace WordPress\AiClient\Messages\Enums;

use WordPress\AiClient\Common\AbstractEnum;

/**
 * Enum for message part types
 *
 * @since n.e.x.t
 * @method static self text() Create an instance for TEXT type
 * @method static self inlineFile() Create an instance for INLINE_FILE type
 * @method static self remoteFile() Create an instance for REMOTE_FILE type
 * @method static self functionCall() Create an instance for FUNCTION_CALL type
 * @method static self functionResponse() Create an instance for FUNCTION_RESPONSE type
 * @method bool isText() Check if the type is TEXT
 * @method bool isInlineFile() Check if the type is INLINE_FILE
 * @method bool isRemoteFile() Check if the type is REMOTE_FILE
 * @method bool isFunctionCall() Check if the type is FUNCTION_CALL
 * @method bool isFunctionResponse() Check if the type is FUNCTION_RESPONSE
 */
class MessagePartTypeEnum extends AbstractEnum
{
    /**
     * Text content
     */
    public const TEXT = 'text';

    /**
     * Inline file content (base64 encoded)
     */
    public const INLINE_FILE = 'inline_file';

    /**
     * Remote file reference (URL)
     */
    public const REMOTE_FILE = 'remote_file';

    /**
     * Function call request
     */
    public const FUNCTION_CALL = 'function_call';

    /**
     * Function response
     */
    public const FUNCTION_RESPONSE = 'function_response';
}
