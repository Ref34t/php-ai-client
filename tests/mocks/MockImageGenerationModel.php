<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\mocks;

use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\DTO\ModelConfig;
use WordPress\AiClient\Providers\Models\DTO\ModelMetadata;
use WordPress\AiClient\Providers\Models\Enums\CapabilityEnum;
use WordPress\AiClient\Providers\Models\ImageGeneration\Contracts\ImageGenerationModelInterface;
use WordPress\AiClient\Results\DTO\GenerativeAiResult;

/**
 * Mock image generation model for testing.
 *
 * @since n.e.x.t
 */
class MockImageGenerationModel implements ModelInterface, ImageGenerationModelInterface
{
    /**
     * @var ModelMetadata The model metadata.
     */
    private ModelMetadata $metadata;

    /**
     * @var ModelConfig The model configuration.
     */
    private ModelConfig $config;

    /**
     * Constructor.
     *
     * @param ModelMetadata|null $metadata The model metadata.
     * @param ModelConfig|null $config The model configuration.
     */
    public function __construct(?ModelMetadata $metadata = null, ?ModelConfig $config = null)
    {
        $this->metadata = $metadata ?? new ModelMetadata(
            'mock-image-model',
            'Mock Image Model',
            [CapabilityEnum::imageGeneration()],
            []
        );
        $this->config = $config ?? new ModelConfig();
    }

    /**
     * {@inheritDoc}
     */
    public function metadata(): ModelMetadata
    {
        return $this->metadata;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(): ModelConfig
    {
        return $this->config;
    }

    /**
     * {@inheritDoc}
     */
    public function setConfig(ModelConfig $config): void
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function generateImageResult(array $prompt): GenerativeAiResult
    {
        // Return a mock result
        throw new \RuntimeException('Mock implementation - should be mocked in tests');
    }
}
