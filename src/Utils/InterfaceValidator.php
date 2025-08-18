<?php

declare(strict_types=1);

namespace WordPress\AiClient\Utils;

use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\EmbeddingGeneration\Contracts\EmbeddingGenerationModelInterface;
use WordPress\AiClient\Providers\Models\EmbeddingGeneration\Contracts\EmbeddingGenerationOperationModelInterface;
use WordPress\AiClient\Providers\Models\ImageGeneration\Contracts\ImageGenerationModelInterface;
use WordPress\AiClient\Providers\Models\SpeechGeneration\Contracts\SpeechGenerationModelInterface;
use WordPress\AiClient\Providers\Models\SpeechGeneration\Contracts\SpeechGenerationOperationModelInterface;
use WordPress\AiClient\Providers\Models\TextGeneration\Contracts\TextGenerationModelInterface;
use WordPress\AiClient\Providers\Models\TextToSpeechConversion\Contracts\TextToSpeechConversionModelInterface;
use WordPress\AiClient\Providers\Models\TextToSpeechConversion\Contracts\TextToSpeechConversionOperationModelInterface;

/**
 * Utility class for validating model interface implementations.
 *
 * Centralizes interface validation logic to reduce code duplication
 * and provide consistent error messages across the AI Client.
 *
 * @since n.e.x.t
 */
class InterfaceValidator
{
    /**
     * Validation configuration mapping generation types to their interfaces.
     *
     * @var array<string, array{string, string, string}>
     */
    private const VALIDATION_CONFIG = [
        'textGeneration' => [TextGenerationModelInterface::class, 'TextGenerationModelInterface', 'text generation'],
        'imageGeneration' => [ImageGenerationModelInterface::class, 'ImageGenerationModelInterface', 'image generation'],
        'textToSpeechConversion' => [TextToSpeechConversionModelInterface::class, 'TextToSpeechConversionModelInterface', 'text-to-speech conversion'],
        'speechGeneration' => [SpeechGenerationModelInterface::class, 'SpeechGenerationModelInterface', 'speech generation'],
        'embeddingGeneration' => [EmbeddingGenerationModelInterface::class, 'EmbeddingGenerationModelInterface', 'embedding generation'],
        'textGenerationOperation' => [TextGenerationModelInterface::class, 'TextGenerationModelInterface', 'text generation operations'],
        'imageGenerationOperation' => [ImageGenerationModelInterface::class, 'ImageGenerationModelInterface', 'image generation operations'],
        'textToSpeechConversionOperation' => [TextToSpeechConversionOperationModelInterface::class, 'TextToSpeechConversionOperationModelInterface', 'text-to-speech conversion operations'],
        'speechGenerationOperation' => [SpeechGenerationOperationModelInterface::class, 'SpeechGenerationOperationModelInterface', 'speech generation operations'],
        'embeddingGenerationOperation' => [EmbeddingGenerationOperationModelInterface::class, 'EmbeddingGenerationOperationModelInterface', 'embedding generation operations'],
    ];

    /**
     * Generic interface validation method.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @param string $type The validation type from VALIDATION_CONFIG.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    private static function validateInterface(ModelInterface $model, string $type): void
    {
        if (!isset(self::VALIDATION_CONFIG[$type])) {
            throw new \InvalidArgumentException("Unknown validation type: {$type}");
        }

        [$interface, $interfaceName, $description] = self::VALIDATION_CONFIG[$type];
        if (!$model instanceof $interface) {
            throw new \InvalidArgumentException(
                "Model must implement {$interfaceName} for {$description}"
            );
        }
    }
    /**
     * Validates that a model implements TextGenerationModelInterface.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateTextGeneration(ModelInterface $model): void
    {
        self::validateInterface($model, 'textGeneration');
    }

    /**
     * Validates that a model implements ImageGenerationModelInterface.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateImageGeneration(ModelInterface $model): void
    {
        self::validateInterface($model, 'imageGeneration');
    }

    /**
     * Validates that a model implements TextToSpeechConversionModelInterface.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateTextToSpeechConversion(ModelInterface $model): void
    {
        self::validateInterface($model, 'textToSpeechConversion');
    }

    /**
     * Validates that a model implements SpeechGenerationModelInterface.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateSpeechGeneration(ModelInterface $model): void
    {
        self::validateInterface($model, 'speechGeneration');
    }

    /**
     * Validates that a model implements EmbeddingGenerationModelInterface.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateEmbeddingGeneration(ModelInterface $model): void
    {
        self::validateInterface($model, 'embeddingGeneration');
    }

    /**
     * Validates that a model implements TextGenerationModelInterface for operations.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateTextGenerationOperation(ModelInterface $model): void
    {
        self::validateInterface($model, 'textGenerationOperation');
    }

    /**
     * Validates that a model implements ImageGenerationModelInterface for operations.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateImageGenerationOperation(ModelInterface $model): void
    {
        self::validateInterface($model, 'imageGenerationOperation');
    }

    /**
     * Validates that a model implements TextToSpeechConversionOperationModelInterface for operations.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateTextToSpeechConversionOperation(ModelInterface $model): void
    {
        self::validateInterface($model, 'textToSpeechConversionOperation');
    }

    /**
     * Validates that a model implements SpeechGenerationOperationModelInterface for operations.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateSpeechGenerationOperation(ModelInterface $model): void
    {
        self::validateInterface($model, 'speechGenerationOperation');
    }

    /**
     * Validates that a model implements EmbeddingGenerationOperationModelInterface for operations.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If the model doesn't implement the required interface.
     */
    public static function validateEmbeddingGenerationOperation(ModelInterface $model): void
    {
        self::validateInterface($model, 'embeddingGenerationOperation');
    }
}
