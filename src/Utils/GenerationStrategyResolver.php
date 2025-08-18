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
}
