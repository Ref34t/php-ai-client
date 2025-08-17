<?php

declare(strict_types=1);

namespace WordPress\AiClient\Utils;

use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\ImageGeneration\Contracts\ImageGenerationModelInterface;
use WordPress\AiClient\Providers\Models\SpeechGeneration\Contracts\SpeechGenerationModelInterface;
use WordPress\AiClient\Providers\Models\TextGeneration\Contracts\TextGenerationModelInterface;
use WordPress\AiClient\Providers\Models\TextToSpeechConversion\Contracts\TextToSpeechConversionModelInterface;

/**
 * Utility class for resolving generation strategies based on model capabilities.
 *
 * Implements a strategy pattern to determine which generation method
 * should be used for a given model interface.
 *
 * @since n.e.x.t
 */
class GenerationStrategyResolver
{
    /**
     * Strategy mapping for generation methods.
     *
     * Maps interface class names to their corresponding generation method names.
     */
    private const GENERATION_STRATEGIES = [
        TextGenerationModelInterface::class => 'generateTextResult',
        ImageGenerationModelInterface::class => 'generateImageResult',
        TextToSpeechConversionModelInterface::class => 'convertTextToSpeechResult',
        SpeechGenerationModelInterface::class => 'generateSpeechResult',
    ];

    /**
     * Resolves the appropriate generation method for a given model.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to resolve strategy for.
     * @return string The method name to call for generation.
     *
     * @throws \InvalidArgumentException If no supported generation interface is found.
     */
    public static function resolve(ModelInterface $model): string
    {
        foreach (self::GENERATION_STRATEGIES as $interface => $method) {
            if ($model instanceof $interface) {
                return $method;
            }
        }

        throw new \InvalidArgumentException(
            'Model must implement at least one supported generation interface ' .
            '(TextGeneration, ImageGeneration, TextToSpeechConversion, SpeechGeneration)'
        );
    }

    /**
     * Checks if a model supports any generation interface.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to check.
     * @return bool True if the model supports at least one generation interface.
     */
    public static function isSupported(ModelInterface $model): bool
    {
        foreach (self::GENERATION_STRATEGIES as $interface => $method) {
            if ($model instanceof $interface) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets all supported generation interfaces.
     *
     * @since n.e.x.t
     *
     * @return array<string, string> Array of interface => method mappings.
     */
    public static function getSupportedInterfaces(): array
    {
        return self::GENERATION_STRATEGIES;
    }

    /**
     * Gets the generation method name for a specific interface.
     *
     * @since n.e.x.t
     *
     * @param string $interfaceClass The interface class name.
     * @return string|null The method name, or null if interface is not supported.
     */
    public static function getMethodForInterface(string $interfaceClass): ?string
    {
        return self::GENERATION_STRATEGIES[$interfaceClass] ?? null;
    }

    /**
     * Checks if a specific interface is supported for generation.
     *
     * @since n.e.x.t
     *
     * @param string $interfaceClass The interface class name to check.
     * @return bool True if the interface is supported.
     */
    public static function isInterfaceSupported(string $interfaceClass): bool
    {
        return isset(self::GENERATION_STRATEGIES[$interfaceClass]);
    }
}
