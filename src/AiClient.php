<?php

declare(strict_types=1);

namespace WordPress\AiClient;

use Generator;
use WordPress\AiClient\Builders\PromptBuilder;
use WordPress\AiClient\Operations\DTO\GenerativeAiOperation;
use WordPress\AiClient\Providers\Contracts\ProviderAvailabilityInterface;
use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\ImageGeneration\Contracts\ImageGenerationModelInterface;
use WordPress\AiClient\Providers\Models\SpeechGeneration\Contracts\SpeechGenerationModelInterface;
use WordPress\AiClient\Providers\Models\TextGeneration\Contracts\TextGenerationModelInterface;
use WordPress\AiClient\Providers\Models\TextToSpeechConversion\Contracts\TextToSpeechConversionModelInterface;
use WordPress\AiClient\Providers\ProviderRegistry;
use WordPress\AiClient\Results\DTO\GenerativeAiResult;
use WordPress\AiClient\Providers\Models\Enums\CapabilityEnum;

/**
 * Main AI Client class providing both fluent and traditional APIs for AI operations.
 *
 * This class serves as the primary entry point for AI operations, offering:
 * - Fluent API for easy-to-read chained method calls
 * - Traditional API for array-based configuration (WordPress style)
 * - Integration with provider registry for model discovery
 *
 * All model requirements analysis and capability matching is handled
 * automatically by the PromptBuilder, which provides intelligent model
 * discovery based on prompt content and configuration.
 *
 * Example usage:
 * ```php
 * // Fluent API with automatic model discovery
 * $result = AiClient::prompt('Generate an image of a sunset')
 *     ->usingTemperature(0.7)
 *     ->generateImageResult();
 *
 * // Traditional API
 * $result = AiClient::generateTextResult('What is PHP?');
 * ```
 *
 * @since n.e.x.t
 *
 * @phpstan-import-type Prompt from PromptBuilder
 *
 * phpcs:ignore Generic.Files.LineLength.TooLong
 */
class AiClient
{
    /**
     * @var ProviderRegistry|null The default provider registry instance.
     */
    private static ?ProviderRegistry $defaultRegistry = null;

    /**
     * Gets the default provider registry instance.
     *
     * @since n.e.x.t
     *
     * @return ProviderRegistry The default provider registry.
     */
    public static function defaultRegistry(): ProviderRegistry
    {
        if (self::$defaultRegistry === null) {
            $registry = new ProviderRegistry();

            // TODO: Uncomment this once provider implementation PR #39 is merged.
            //$registry->setHttpTransporter(HttpTransporterFactory::createTransporter());
            //$registry->registerProvider(AnthropicProvider::class);
            //$registry->registerProvider(GoogleProvider::class);
            //$registry->registerProvider(OpenAiProvider::class);

            self::$defaultRegistry = $registry;
        }

        return self::$defaultRegistry;
    }

    /**
     * Sets the default provider registry instance.
     *
     * @since n.e.x.t
     *
     * @param ProviderRegistry $registry The provider registry to set as default.
     */
    public static function setDefaultRegistry(ProviderRegistry $registry): void
    {
        self::$defaultRegistry = $registry;
    }

    /**
     * Checks if a provider is configured and available for use.
     *
     * @since n.e.x.t
     *
     * @param ProviderAvailabilityInterface $availability The provider availability instance to check.
     * @return bool True if the provider is configured and available, false otherwise.
     */
    public static function isConfigured(ProviderAvailabilityInterface $availability): bool
    {
        return $availability->isConfigured();
    }

    /**
     * Creates a new prompt builder for fluent API usage.
     *
     * This method will return an actual PromptBuilder instance once PR #49 is merged.
     * The traditional API methods in this class will then delegate to PromptBuilder
     * rather than implementing their own generation logic.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt Optional initial prompt content.
     * @return PromptBuilder The prompt builder instance.
     */
    public static function prompt($prompt = null): PromptBuilder
    {
        return new PromptBuilder(self::defaultRegistry(), $prompt);
    }

    /**
     * Generates content using a unified API that automatically detects model capabilities.
     *
     * When no model is provided, this method delegates to PromptBuilder for intelligent
     * model discovery based on prompt content and configuration. When a model is provided,
     * it routes to the appropriate generation method based on the model's interfaces.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiResult The generation result.
     *
     * @throws \InvalidArgumentException If the provided model doesn't support any known generation type.
     * @throws \RuntimeException If no suitable model can be found for the prompt.
     */
    public static function generateResult($prompt, ?ModelInterface $model = null): GenerativeAiResult
    {
        // If no model provided, use PromptBuilder's intelligent model discovery
        if ($model === null) {
            return self::prompt($prompt)->generateResult();
        }

        // Route based on model interface capabilities
        // Note: Order matters for models that implement multiple interfaces
        if ($model instanceof TextGenerationModelInterface) {
            return self::generateTextResult($prompt, $model);
        }

        if ($model instanceof ImageGenerationModelInterface) {
            return self::generateImageResult($prompt, $model);
        }

        if ($model instanceof TextToSpeechConversionModelInterface) {
            return self::convertTextToSpeechResult($prompt, $model);
        }

        if ($model instanceof SpeechGenerationModelInterface) {
            return self::generateSpeechResult($prompt, $model);
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Model "%s" must implement at least one supported generation interface ' .
                '(TextGeneration, ImageGeneration, TextToSpeechConversion, SpeechGeneration)',
                $model->metadata()->getId()
            )
        );
    }

    /**
     * Generates content using a unified API with explicit capability selection.
     *
     * This method allows explicit capability selection for models that implement
     * multiple generation interfaces. If the model doesn't support the specified
     * capability, an exception is thrown.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param CapabilityEnum $capability The desired generation capability.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiResult The generation result.
     *
     * @throws \InvalidArgumentException If the model doesn't support the specified capability.
     * @throws \RuntimeException If no suitable model can be found for the prompt and capability.
     */
    public static function generateResultWithCapability(
        $prompt,
        CapabilityEnum $capability,
        ?ModelInterface $model = null
    ): GenerativeAiResult
    {
        // If no model provided, use PromptBuilder with explicit capability
        if ($model === null) {
            return self::prompt($prompt)->generateResult($capability);
        }

        // Validate that the model supports the requested capability
        if (!$model->metadata()->supportsCapability($capability)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Model "%s" does not support the "%s" capability',
                    $model->metadata()->getId(),
                    $capability->value
                )
            );
        }

        // Route to the appropriate method based on capability
        if ($capability->isTextGeneration()) {
            return self::generateTextResult($prompt, $model);
        }

        if ($capability->isImageGeneration()) {
            return self::generateImageResult($prompt, $model);
        }

        if ($capability->isTextToSpeechConversion()) {
            return self::convertTextToSpeechResult($prompt, $model);
        }

        if ($capability->isSpeechGeneration()) {
            return self::generateSpeechResult($prompt, $model);
        }

        throw new \InvalidArgumentException(
            sprintf('Capability "%s" is not yet supported for generation', $capability->value)
        );
    }

    /**
     * Creates a new message builder for fluent API usage.
     *
     * This method will be implemented once MessageBuilder is available.
     * MessageBuilder will provide a fluent interface for constructing complex
     * messages with multiple parts, attachments, and metadata.
     *
     * @since n.e.x.t
     *
     * @param string|null $text Optional initial message text.
     * @return object MessageBuilder instance (type will be updated when MessageBuilder is available).
     *
     * @throws \RuntimeException When MessageBuilder is not yet available.
     */
    public static function message(?string $text = null)
    {
        throw new \RuntimeException(
            'MessageBuilder is not yet available. This method depends on builder infrastructure. ' .
            'Use direct generation methods (generateTextResult, generateImageResult, etc.) for now.'
        );
    }

    /**
     * Generates text using the traditional API approach.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiResult The generation result.
     *
     * @throws \InvalidArgumentException If the prompt format is invalid.
     * @throws \RuntimeException If no suitable model is found.
     */
    public static function generateTextResult($prompt, ?ModelInterface $model = null): GenerativeAiResult
    {
        $builder = self::prompt($prompt);
        if ($model !== null) {
            $builder->usingModel($model);
        }
        return $builder->generateTextResult();
    }

    /**
     * Streams text generation using the traditional API approach.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return Generator<GenerativeAiResult> Generator yielding partial text generation results.
     *
     * @throws \RuntimeException Always throws - streaming is not implemented yet.
     */
    public static function streamGenerateTextResult($prompt, ?ModelInterface $model = null): Generator
    {
        throw new \RuntimeException(
            'Text streaming is not implemented yet. Use generateTextResult() for non-streaming text generation.'
        );
    }

    /**
     * Generates an image using the traditional API approach.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiResult The generation result.
     *
     * @throws \InvalidArgumentException If the prompt format is invalid.
     * @throws \RuntimeException If no suitable model is found.
     */
    public static function generateImageResult($prompt, ?ModelInterface $model = null): GenerativeAiResult
    {
        $builder = self::prompt($prompt);
        if ($model !== null) {
            $builder->usingModel($model);
        }
        return $builder->generateImageResult();
    }

    /**
     * Converts text to speech using the traditional API approach.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiResult The generation result.
     *
     * @throws \InvalidArgumentException If the prompt format is invalid.
     * @throws \RuntimeException If no suitable model is found.
     */
    public static function convertTextToSpeechResult($prompt, ?ModelInterface $model = null): GenerativeAiResult
    {
        $builder = self::prompt($prompt);
        if ($model !== null) {
            $builder->usingModel($model);
        }
        return $builder->convertTextToSpeechResult();
    }

    /**
     * Generates speech using the traditional API approach.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiResult The generation result.
     *
     * @throws \InvalidArgumentException If the prompt format is invalid.
     * @throws \RuntimeException If no suitable model is found.
     */
    public static function generateSpeechResult($prompt, ?ModelInterface $model = null): GenerativeAiResult
    {
        $builder = self::prompt($prompt);
        if ($model !== null) {
            $builder->usingModel($model);
        }
        return $builder->generateSpeechResult();
    }

    /**
     * Creates a generation operation for async processing.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiOperation The operation for async processing.
     *
     * @throws \RuntimeException Operations are not implemented yet.
     */
    public static function generateOperation($prompt, ?ModelInterface $model = null): GenerativeAiOperation
    {
        throw new \RuntimeException(
            'Operations are not implemented yet. This functionality is planned for a future release.'
        );
    }

    /**
     * Creates a text generation operation for async processing.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiOperation The operation for async text processing.
     *
     * @throws \RuntimeException Operations are not implemented yet.
     */
    public static function generateTextOperation($prompt, ?ModelInterface $model = null): GenerativeAiOperation
    {
        throw new \RuntimeException(
            'Text generation operations are not implemented yet. This functionality is planned for a future release.'
        );
    }

    /**
     * Creates an image generation operation for async processing.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiOperation The operation for async image processing.
     *
     * @throws \RuntimeException Operations are not implemented yet.
     */
    public static function generateImageOperation($prompt, ?ModelInterface $model = null): GenerativeAiOperation
    {
        throw new \RuntimeException(
            'Image generation operations are not implemented yet. This functionality is planned for a future release.'
        );
    }

    /**
     * Creates a text-to-speech conversion operation for async processing.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiOperation The operation for async text-to-speech processing.
     *
     * @throws \RuntimeException Operations are not implemented yet.
     */
    public static function convertTextToSpeechOperation($prompt, ?ModelInterface $model = null): GenerativeAiOperation
    {
        throw new \RuntimeException(
            'Text-to-speech conversion operations are not implemented yet. ' .
            'This functionality is planned for a future release.'
        );
    }

    /**
     * Creates a speech generation operation for async processing.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return GenerativeAiOperation The operation for async speech processing.
     *
     * @throws \RuntimeException Operations are not implemented yet.
     */
    public static function generateSpeechOperation($prompt, ?ModelInterface $model = null): GenerativeAiOperation
    {
        throw new \RuntimeException(
            'Speech generation operations are not implemented yet. This functionality is planned for a future release.'
        );
    }

    /**
     * Convenience method for text generation.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return string The generated text.
     */
    public static function generateText($prompt, ?ModelInterface $model = null): string
    {
        return self::generateTextResult($prompt, $model)->toText();
    }

    /**
     * Convenience method for image generation.
     *
     * @since n.e.x.t
     *
     * @param Prompt $prompt The prompt content.
     * @param ModelInterface|null $model Optional specific model to use.
     * @return \WordPress\AiClient\Files\DTO\File The generated image file.
     */
    public static function generateImage($prompt, ?ModelInterface $model = null)
    {
        return self::generateImageResult($prompt, $model)->toFile();
    }
}
