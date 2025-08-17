<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\unit\Utils;

use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Providers\ProviderRegistry;
use WordPress\AiClient\Utils\ModelDiscovery;

/**
 * @covers \WordPress\AiClient\Utils\ModelDiscovery
 */
class ModelDiscoveryTest extends TestCase
{
    private ProviderRegistry $registry;

    protected function setUp(): void
    {
        $this->registry = $this->createMock(ProviderRegistry::class);
    }

    /**
     * Tests findTextModel throws exception when no models available.
     */
    public function testFindTextModelThrowsExceptionWhenNoModelsAvailable(): void
    {
        $this->registry->expects($this->once())
            ->method('findModelsMetadataForSupport')
            ->willReturn([]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No text generation models available');

        ModelDiscovery::findTextModel($this->registry);
    }

    /**
     * Tests findImageModel throws exception when no models available.
     */
    public function testFindImageModelThrowsExceptionWhenNoModelsAvailable(): void
    {
        $this->registry->expects($this->once())
            ->method('findModelsMetadataForSupport')
            ->willReturn([]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No image generation models available');

        ModelDiscovery::findImageModel($this->registry);
    }

    /**
     * Tests findTextToSpeechModel throws exception when no models available.
     */
    public function testFindTextToSpeechModelThrowsExceptionWhenNoModelsAvailable(): void
    {
        $this->registry->expects($this->once())
            ->method('findModelsMetadataForSupport')
            ->willReturn([]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No text-to-speech conversion models available');

        ModelDiscovery::findTextToSpeechModel($this->registry);
    }

    /**
     * Tests findSpeechModel throws exception when no models available.
     */
    public function testFindSpeechModelThrowsExceptionWhenNoModelsAvailable(): void
    {
        $this->registry->expects($this->once())
            ->method('findModelsMetadataForSupport')
            ->willReturn([]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No speech generation models available');

        ModelDiscovery::findSpeechModel($this->registry);
    }

    /**
     * Tests findEmbeddingModel throws exception when no models available.
     */
    public function testFindEmbeddingModelThrowsExceptionWhenNoModelsAvailable(): void
    {
        $this->registry->expects($this->once())
            ->method('findModelsMetadataForSupport')
            ->willReturn([]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No embedding generation models available');

        ModelDiscovery::findEmbeddingModel($this->registry);
    }

    /**
     * Tests that ModelDiscovery properly passes capability requirements to registry.
     */
    public function testModelDiscoveryPassesCorrectCapabilityRequirements(): void
    {
        // Mock registry to capture the ModelRequirements parameter
        $this->registry->expects($this->once())
            ->method('findModelsMetadataForSupport')
            ->with($this->callback(function ($requirements) {
                // Verify that the ModelRequirements contains the expected capability
                $capabilities = $requirements->getRequiredCapabilities();
                return count($capabilities) === 1 &&
                       $capabilities[0]->value === 'text_generation';
            }))
            ->willReturn([]);

        $this->expectException(\RuntimeException::class);
        ModelDiscovery::findTextModel($this->registry);
    }
}
