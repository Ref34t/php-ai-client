<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers;

use Exception;
use WordPress\AiClient\Messages\DTO\Message;
use WordPress\AiClient\Messages\DTO\MessagePart;
use WordPress\AiClient\Messages\Enums\MessageRoleEnum;
use WordPress\AiClient\Providers\Contracts\ProviderAvailabilityInterface;
use WordPress\AiClient\Providers\Models\Contracts\ModelInterface;
use WordPress\AiClient\Providers\Models\DTO\ModelConfig;
use WordPress\AiClient\Providers\Models\TextGeneration\Contracts\TextGenerationModelInterface;

/**
 * Class to check availability for an API-based provider via a test request to the endpoint to generate text.
 *
 * @since n.e.x.t
 */
class GenerateTextApiBasedProviderAvailability implements ProviderAvailabilityInterface
{
    /**
     * @var ModelInterface&TextGenerationModelInterface The model to use for checking availability.
     */
    private ModelInterface $model;

    /**
     * Constructor.
     *
     * @since n.e.x.t
     *
     * @param ModelInterface $model The model to use for checking availability.
     */
    public function __construct(ModelInterface $model)
    {
        if (!($model instanceof TextGenerationModelInterface)) {
            throw new Exception(
                'The model class to check provider availability must implement TextGenerationModelInterface.'
            );
        }
        $this->model = $model;
    }

    /**
     * Checks whether the provider is available.
     *
     * @since n.e.x.t
     *
     * @return bool True if the provider is available, false otherwise.
     */
    public function isConfigured(): bool
    {
        // Set config to use as few resources as possible for the test.
        $modelConfig = ModelConfig::fromArray([
            ModelConfig::KEY_MAX_TOKENS => 1,
        ]);
        $this->model->setConfig($modelConfig);

        try {
            // Attempt to generate text to check if the provider is available.
            $this->model->generateTextResult([
                Message::fromArray([
                    Message::KEY_ROLE => MessageRoleEnum::user(),
                    Message::KEY_PARTS => [[MessagePart::KEY_TEXT => 'a']],
                ]),
            ]);
            return true;
        } catch (Exception $e) {
            // If an exception occurs, the provider is not available.
            return false;
        }
    }
}
