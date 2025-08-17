<?php

declare(strict_types=1);

namespace WordPress\AiClient\Utils;

use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\DTO\ModelRequirements;
use WordPress\AiClient\Providers\Models\Enums\CapabilityEnum;
use WordPress\AiClient\Providers\ProviderRegistry;

/**
 * Utility class for auto-discovering suitable models based on capabilities.
 *
 * @since n.e.x.t
 */
class ModelDiscovery
{
    /**
     * Finds a suitable text generation model from the registry.
     *
     * @since n.e.x.t
     *
     * @param ProviderRegistry $registry The provider registry to search.
     * @return ModelInterface A suitable text generation model.
     *
     * @throws \RuntimeException If no suitable model is found.
     */
    public static function findTextModel(ProviderRegistry $registry): ModelInterface
    {
        $requirements = new ModelRequirements([CapabilityEnum::textGeneration()], []);
        $providerModelsMetadata = $registry->findModelsMetadataForSupport($requirements);

        if (empty($providerModelsMetadata)) {
            throw new \RuntimeException('No text generation models available');
        }

        // Get the first suitable provider and model
        $providerMetadata = $providerModelsMetadata[0];
        $models = $providerMetadata->getModels();

        if (empty($models)) {
            throw new \RuntimeException('No models available in provider');
        }

        return $registry->getProviderModel(
            $providerMetadata->getProvider()->getId(),
            $models[0]->getId()
        );
    }

    /**
     * Finds a suitable image generation model from the registry.
     *
     * @since n.e.x.t
     *
     * @param ProviderRegistry $registry The provider registry to search.
     * @return ModelInterface A suitable image generation model.
     *
     * @throws \RuntimeException If no suitable model is found.
     */
    public static function findImageModel(ProviderRegistry $registry): ModelInterface
    {
        $requirements = new ModelRequirements([CapabilityEnum::imageGeneration()], []);
        $providerModelsMetadata = $registry->findModelsMetadataForSupport($requirements);

        if (empty($providerModelsMetadata)) {
            throw new \RuntimeException('No image generation models available');
        }

        // Get the first suitable provider and model
        $providerMetadata = $providerModelsMetadata[0];
        $models = $providerMetadata->getModels();

        if (empty($models)) {
            throw new \RuntimeException('No models available in provider');
        }

        return $registry->getProviderModel(
            $providerMetadata->getProvider()->getId(),
            $models[0]->getId()
        );
    }

    /**
     * Finds a suitable text-to-speech conversion model from the registry.
     *
     * @since n.e.x.t
     *
     * @param ProviderRegistry $registry The provider registry to search.
     * @return ModelInterface A suitable text-to-speech conversion model.
     *
     * @throws \RuntimeException If no suitable model is found.
     */
    public static function findTextToSpeechModel(ProviderRegistry $registry): ModelInterface
    {
        $requirements = new ModelRequirements([CapabilityEnum::textToSpeechConversion()], []);
        $providerModelsMetadata = $registry->findModelsMetadataForSupport($requirements);

        if (empty($providerModelsMetadata)) {
            throw new \RuntimeException('No text-to-speech conversion models available');
        }

        // Get the first suitable provider and model
        $providerMetadata = $providerModelsMetadata[0];
        $models = $providerMetadata->getModels();

        if (empty($models)) {
            throw new \RuntimeException('No models available in provider');
        }

        return $registry->getProviderModel(
            $providerMetadata->getProvider()->getId(),
            $models[0]->getId()
        );
    }

    /**
     * Finds a suitable speech generation model from the registry.
     *
     * @since n.e.x.t
     *
     * @param ProviderRegistry $registry The provider registry to search.
     * @return ModelInterface A suitable speech generation model.
     *
     * @throws \RuntimeException If no suitable model is found.
     */
    public static function findSpeechModel(ProviderRegistry $registry): ModelInterface
    {
        $requirements = new ModelRequirements([CapabilityEnum::speechGeneration()], []);
        $providerModelsMetadata = $registry->findModelsMetadataForSupport($requirements);

        if (empty($providerModelsMetadata)) {
            throw new \RuntimeException('No speech generation models available');
        }

        // Get the first suitable provider and model
        $providerMetadata = $providerModelsMetadata[0];
        $models = $providerMetadata->getModels();

        if (empty($models)) {
            throw new \RuntimeException('No models available in provider');
        }

        return $registry->getProviderModel(
            $providerMetadata->getProvider()->getId(),
            $models[0]->getId()
        );
    }

    /**
     * Finds a suitable embedding generation model from the registry.
     *
     * @since n.e.x.t
     *
     * @param ProviderRegistry $registry The provider registry to search.
     * @return ModelInterface A suitable embedding generation model.
     *
     * @throws \RuntimeException If no suitable model is found.
     */
    public static function findEmbeddingModel(ProviderRegistry $registry): ModelInterface
    {
        $requirements = new ModelRequirements([CapabilityEnum::embeddingGeneration()], []);
        $providerModelsMetadata = $registry->findModelsMetadataForSupport($requirements);

        if (empty($providerModelsMetadata)) {
            throw new \RuntimeException('No embedding generation models available');
        }

        // Get the first suitable provider and model
        $providerMetadata = $providerModelsMetadata[0];
        $models = $providerMetadata->getModels();

        if (empty($models)) {
            throw new \RuntimeException('No models available in provider');
        }

        return $registry->getProviderModel(
            $providerMetadata->getProvider()->getId(),
            $models[0]->getId()
        );
    }
}
