<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\unit\Utils;

use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Tests\mocks\MockEmbeddingGenerationModel;
use WordPress\AiClient\Tests\mocks\MockEmbeddingGenerationOperationModel;
use WordPress\AiClient\Tests\mocks\MockImageGenerationModel;
use WordPress\AiClient\Tests\mocks\MockTextGenerationModel;
use WordPress\AiClient\Utils\InterfaceValidator;

/**
 * @covers \WordPress\AiClient\Utils\InterfaceValidator
 */
class InterfaceValidatorTest extends TestCase
{
    /**
     * Tests validateTextGeneration with valid text model.
     */
    public function testValidateTextGenerationWithValidModel(): void
    {
        $model = $this->createMock(MockTextGenerationModel::class);

        // Should not throw an exception
        InterfaceValidator::validateTextGeneration($model);

        // If we reach here, validation passed
        $this->assertTrue(true);
    }

    /**
     * Tests validateTextGeneration with invalid model.
     */
    public function testValidateTextGenerationWithInvalidModel(): void
    {
        $model = $this->createMock(ModelInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Model must implement TextGenerationModelInterface for text generation'
        );

        InterfaceValidator::validateTextGeneration($model);
    }

    /**
     * Tests validateImageGeneration with valid image model.
     */
    public function testValidateImageGenerationWithValidModel(): void
    {
        $model = $this->createMock(MockImageGenerationModel::class);

        // Should not throw an exception
        InterfaceValidator::validateImageGeneration($model);

        // If we reach here, validation passed
        $this->assertTrue(true);
    }

    /**
     * Tests validateImageGeneration with invalid model.
     */
    public function testValidateImageGenerationWithInvalidModel(): void
    {
        $model = $this->createMock(ModelInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Model must implement ImageGenerationModelInterface for image generation'
        );

        InterfaceValidator::validateImageGeneration($model);
    }

    /**
     * Tests validateEmbeddingGeneration with valid embedding model.
     */
    public function testValidateEmbeddingGenerationWithValidModel(): void
    {
        $model = $this->createMock(MockEmbeddingGenerationModel::class);

        // Should not throw an exception
        InterfaceValidator::validateEmbeddingGeneration($model);

        // If we reach here, validation passed
        $this->assertTrue(true);
    }

    /**
     * Tests validateEmbeddingGeneration with invalid model.
     */
    public function testValidateEmbeddingGenerationWithInvalidModel(): void
    {
        $model = $this->createMock(ModelInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Model must implement EmbeddingGenerationModelInterface for embedding generation'
        );

        InterfaceValidator::validateEmbeddingGeneration($model);
    }

    /**
     * Tests validateTextGenerationOperation with valid text model.
     */
    public function testValidateTextGenerationOperationWithValidModel(): void
    {
        $model = $this->createMock(MockTextGenerationModel::class);

        // Should not throw an exception
        InterfaceValidator::validateTextGenerationOperation($model);

        // If we reach here, validation passed
        $this->assertTrue(true);
    }

    /**
     * Tests validateTextGenerationOperation with invalid model.
     */
    public function testValidateTextGenerationOperationWithInvalidModel(): void
    {
        $model = $this->createMock(ModelInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Model must implement TextGenerationModelInterface for text generation operations'
        );

        InterfaceValidator::validateTextGenerationOperation($model);
    }

    /**
     * Tests validateImageGenerationOperation with valid image model.
     */
    public function testValidateImageGenerationOperationWithValidModel(): void
    {
        $model = $this->createMock(MockImageGenerationModel::class);

        // Should not throw an exception
        InterfaceValidator::validateImageGenerationOperation($model);

        // If we reach here, validation passed
        $this->assertTrue(true);
    }

    /**
     * Tests validateImageGenerationOperation with invalid model.
     */
    public function testValidateImageGenerationOperationWithInvalidModel(): void
    {
        $model = $this->createMock(ModelInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Model must implement ImageGenerationModelInterface for image generation operations'
        );

        InterfaceValidator::validateImageGenerationOperation($model);
    }

    /**
     * Tests validateEmbeddingGenerationOperation with valid embedding operation model.
     */
    public function testValidateEmbeddingGenerationOperationWithValidModel(): void
    {
        $model = $this->createMock(MockEmbeddingGenerationOperationModel::class);

        // Should not throw an exception
        InterfaceValidator::validateEmbeddingGenerationOperation($model);

        // If we reach here, validation passed
        $this->assertTrue(true);
    }

    /**
     * Tests validateEmbeddingGenerationOperation with invalid model.
     */
    public function testValidateEmbeddingGenerationOperationWithInvalidModel(): void
    {
        $model = $this->createMock(ModelInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Model must implement EmbeddingGenerationOperationModelInterface ' .
            'for embedding generation operations'
        );

        InterfaceValidator::validateEmbeddingGenerationOperation($model);
    }
}
