<?php

declare(strict_types=1);

namespace WordPress\AiClient\Contracts;

use WordPress\AiClient\Messages\DTO\Message;
use WordPress\AiClient\Results\DTO\GenerativeAiResult;

/**
 * Interface for AI Client implementations.
 *
 * Defines the contract for classes that provide AI client functionality,
 * allowing for different implementations while maintaining a consistent API.
 *
 * @since n.e.x.t
 */
interface AiClientInterface
{
    /**
     * Sends a message to an AI provider and returns the result.
     *
     * @since n.e.x.t
     *
     * @param string $providerId The provider identifier.
     * @param string $modelId The model identifier.
     * @param Message $message The message to send.
     * @return GenerativeAiResult The AI response.
     */
    public function sendMessage(string $providerId, string $modelId, Message $message): GenerativeAiResult;
}
