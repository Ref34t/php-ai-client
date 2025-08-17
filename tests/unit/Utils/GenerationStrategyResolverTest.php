<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\unit\Utils;

use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\ImageGeneration\Contracts\ImageGenerationModelInterface;
use WordPress\AiClient\Providers\Models\SpeechGeneration\Contracts\SpeechGenerationModelInterface;
use WordPress\AiClient\Providers\Models\TextGeneration\Contracts\TextGenerationModelInterface;
use WordPress\AiClient\Providers\Models\TextToSpeechConversion\Contracts\TextToSpeechConversionModelInterface;
use WordPress\AiClient\Tests\mocks\MockImageGenerationModel;
use WordPress\AiClient\Tests\mocks\MockTextGenerationModel;
use WordPress\AiClient\Utils\GenerationStrategyResolver;

/**
 * @covers \WordPress\AiClient\Utils\GenerationStrategyResolver
 */
class GenerationStrategyResolverTest extends TestCase
{
    /**
     * Tests resolve returns correct method for text generation model.
     */
    public function testResolveReturnsTextGenerationMethod(): void
    {
        $model = $this->createMock(MockTextGenerationModel::class);

        $method = GenerationStrategyResolver::resolve($model);

        $this->assertEquals('generateTextResult', $method);
    }

    /**
     * Tests resolve returns correct method for image generation model.
     */
    public function testResolveReturnsImageGenerationMethod(): void
    {
        $model = $this->createMock(MockImageGenerationModel::class);

        $method = GenerationStrategyResolver::resolve($model);

        $this->assertEquals('generateImageResult', $method);
    }

    /**
     * Tests resolve throws exception for unsupported model.
     */
    public function testResolveThrowsExceptionForUnsupportedModel(): void
    {
        $model = $this->createMock(ModelInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Model must implement at least one supported generation interface ' .
            '(TextGeneration, ImageGeneration, TextToSpeechConversion, SpeechGeneration)'
        );

        GenerationStrategyResolver::resolve($model);
    }

    /**
     * Tests isSupported returns true for supported models.
     */
    public function testIsSupportedReturnsTrueForSupportedModels(): void
    {
        $textModel = $this->createMock(MockTextGenerationModel::class);
        $imageModel = $this->createMock(MockImageGenerationModel::class);

        $this->assertTrue(GenerationStrategyResolver::isSupported($textModel));
        $this->assertTrue(GenerationStrategyResolver::isSupported($imageModel));
    }

    /**
     * Tests isSupported returns false for unsupported models.
     */
    public function testIsSupportedReturnsFalseForUnsupportedModels(): void
    {
        $model = $this->createMock(ModelInterface::class);

        $this->assertFalse(GenerationStrategyResolver::isSupported($model));
    }

    /**
     * Tests getSupportedInterfaces returns all supported interfaces.
     */
    public function testGetSupportedInterfacesReturnsAllInterfaces(): void
    {
        $interfaces = GenerationStrategyResolver::getSupportedInterfaces();

        $expected = [
            TextGenerationModelInterface::class => 'generateTextResult',
            ImageGenerationModelInterface::class => 'generateImageResult',
            TextToSpeechConversionModelInterface::class => 'convertTextToSpeechResult',
            SpeechGenerationModelInterface::class => 'generateSpeechResult',
        ];

        $this->assertEquals($expected, $interfaces);
        $this->assertCount(4, $interfaces);
    }

    /**
     * Tests getMethodForInterface returns correct method for known interface.
     */
    public function testGetMethodForInterfaceReturnsCorrectMethod(): void
    {
        $method = GenerationStrategyResolver::getMethodForInterface(
            TextGenerationModelInterface::class
        );

        $this->assertEquals('generateTextResult', $method);
    }

    /**
     * Tests getMethodForInterface returns null for unknown interface.
     */
    public function testGetMethodForInterfaceReturnsNullForUnknownInterface(): void
    {
        $method = GenerationStrategyResolver::getMethodForInterface('UnknownInterface');

        $this->assertNull($method);
    }

    /**
     * Tests isInterfaceSupported returns true for supported interfaces.
     */
    public function testIsInterfaceSupportedReturnsTrueForSupportedInterfaces(): void
    {
        $this->assertTrue(GenerationStrategyResolver::isInterfaceSupported(
            TextGenerationModelInterface::class
        ));
        $this->assertTrue(GenerationStrategyResolver::isInterfaceSupported(
            ImageGenerationModelInterface::class
        ));
        $this->assertTrue(GenerationStrategyResolver::isInterfaceSupported(
            TextToSpeechConversionModelInterface::class
        ));
        $this->assertTrue(GenerationStrategyResolver::isInterfaceSupported(
            SpeechGenerationModelInterface::class
        ));
    }

    /**
     * Tests isInterfaceSupported returns false for unsupported interfaces.
     */
    public function testIsInterfaceSupportedReturnsFalseForUnsupportedInterfaces(): void
    {
        $this->assertFalse(GenerationStrategyResolver::isInterfaceSupported('UnknownInterface'));
        $this->assertFalse(GenerationStrategyResolver::isInterfaceSupported(ModelInterface::class));
    }

    /**
     * Tests that resolve prioritizes text generation when model implements multiple interfaces.
     */
    public function testResolvePrioritizesTextGeneration(): void
    {
        // Create a mock that implements both text and image generation
        $model = $this->getMockBuilder(MockTextGenerationModel::class)
            ->addMethods([])
            ->getMock();

        // Should return text generation method (first in the strategy order)
        $method = GenerationStrategyResolver::resolve($model);
        $this->assertEquals('generateTextResult', $method);
    }

    /**
     * Tests that all expected interfaces are covered by the resolver.
     */
    public function testAllExpectedInterfacesAreCovered(): void
    {
        $supportedInterfaces = GenerationStrategyResolver::getSupportedInterfaces();

        // Verify all expected interfaces are present
        $this->assertArrayHasKey(TextGenerationModelInterface::class, $supportedInterfaces);
        $this->assertArrayHasKey(ImageGenerationModelInterface::class, $supportedInterfaces);
        $this->assertArrayHasKey(TextToSpeechConversionModelInterface::class, $supportedInterfaces);
        $this->assertArrayHasKey(SpeechGenerationModelInterface::class, $supportedInterfaces);

        // Verify methods are correctly mapped
        $this->assertEquals('generateTextResult', $supportedInterfaces[TextGenerationModelInterface::class]);
        $this->assertEquals('generateImageResult', $supportedInterfaces[ImageGenerationModelInterface::class]);
        $this->assertEquals(
            'convertTextToSpeechResult',
            $supportedInterfaces[TextToSpeechConversionModelInterface::class]
        );
        $this->assertEquals('generateSpeechResult', $supportedInterfaces[SpeechGenerationModelInterface::class]);
    }
}
