<?php

declare(strict_types=1);

namespace WordPress\AiClient\Operations\Enums;

use WordPress\AiClient\Common\AbstractEnum;

/**
 * Enum for operation states
 *
 * @since n.e.x.t
 * @method static self starting() Create an instance for STARTING state
 * @method static self processing() Create an instance for PROCESSING state
 * @method static self succeeded() Create an instance for SUCCEEDED state
 * @method static self failed() Create an instance for FAILED state
 * @method static self canceled() Create an instance for CANCELED state
 * @method bool isStarting() Check if the state is STARTING
 * @method bool isProcessing() Check if the state is PROCESSING
 * @method bool isSucceeded() Check if the state is SUCCEEDED
 * @method bool isFailed() Check if the state is FAILED
 * @method bool isCanceled() Check if the state is CANCELED
 */
class OperationStateEnum extends AbstractEnum
{
    /**
     * Operation is starting
     */
    public const STARTING = 'starting';

    /**
     * Operation is processing
     */
    public const PROCESSING = 'processing';

    /**
     * Operation succeeded
     */
    public const SUCCEEDED = 'succeeded';

    /**
     * Operation failed
     */
    public const FAILED = 'failed';

    /**
     * Operation was canceled
     */
    public const CANCELED = 'canceled';
}
