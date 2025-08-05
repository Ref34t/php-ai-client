<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers;

use InvalidArgumentException;
use WordPress\AiClient\Providers\DTO\ProviderMetadata;
use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\Contracts\WithHttpTransporterInterface;
use WordPress\AiClient\Providers\Models\DTO\ModelConfig;
use WordPress\AiClient\Providers\Models\DTO\ModelMetadata;
use WordPress\AiClient\Providers\Models\Traits\WithHttpTransporterTrait;

/**
 * Base class for an API-based model for a provider.
 *
 * @since n.e.x.t
 */
abstract class AbstractApiBasedModel implements
    ModelInterface,
    WithHttpTransporterInterface
{
    use WithHttpTransporterTrait;

    /**
     * @var ModelMetadata The metadata for the model.
     */
    private ModelMetadata $metadata;

    /**
     * @var ProviderMetadata The metadata for the model's provider.
     */
    private ProviderMetadata $providerMetadata;

    /**
     * @var ModelConfig The configuration for the model.
     */
    private ModelConfig $config;

    /**
     * Constructor.
     *
     * @since n.e.x.t
     *
     * @param ModelMetadata $metadata The metadata for the model.
     * @param ProviderMetadata $providerMetadata The metadata for the model's provider.
     */
    public function __construct(ModelMetadata $metadata, ProviderMetadata $providerMetadata)
    {
        $this->metadata = $metadata;
        $this->providerMetadata = $providerMetadata;
        $this->config = ModelConfig::fromArray([]);
    }

    /**
     * Returns the metadata for the model.
     *
     * @since n.e.x.t
     *
     * @return ModelMetadata The model metadata.
     */
    public function metadata(): ModelMetadata
    {
        return $this->metadata;
    }

    /**
     * Returns the metadata for the model's provider.
     *
     * @since n.e.x.t
     *
     * @return ProviderMetadata The provider metadata.
     */
    public function providerMetadata(): ProviderMetadata
    {
        return $this->providerMetadata;
    }

    /**
     * Sets the configuration for the model.
     *
     * @since n.e.x.t
     *
     * @param ModelConfig $config The configuration for the model.
     */
    public function setConfig(ModelConfig $config): void
    {
        $this->config = $config;
    }

    /**
     * Returns the configuration for the model.
     *
     * @since n.e.x.t
     *
     * @return ModelConfig The model configuration.
     */
    public function getConfig(): ModelConfig
    {
        return $this->config;
    }
}
