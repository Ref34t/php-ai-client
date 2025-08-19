<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\unit\Utils;

use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
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
     */
    {

        // Should not throw an exception

        // If we reach here, validation passed
        $this->assertTrue(true);
    }

    /**
     */
    {
        $model = $this->createMock(ModelInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
        );

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
     */
    {

        // Should not throw an exception

        // If we reach here, validation passed
        $this->assertTrue(true);
    }

    /**
     */
    {
        $model = $this->createMock(ModelInterface::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'for embedding generation operations'
        );

    }
}
