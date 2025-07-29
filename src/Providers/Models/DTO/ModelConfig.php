<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Models\DTO;

use WordPress\AiClient\Common\AbstractDataValueObject;
use WordPress\AiClient\Messages\Enums\ModalityEnum;
use WordPress\AiClient\Tools\DTO\Tool;

/**
 * Represents configuration for an AI model.
 *
 * This class allows configuring various parameters for model behavior,
 * including output modalities, system instructions, generation parameters,
 * and tool integrations.
 *
 * @since n.e.x.t
 *
 * @phpstan-import-type ToolArrayShape from Tool
 *
 * @phpstan-type ModelConfigArrayShape array{
 *     outputModalities?: array<int, string>,
 *     systemInstruction?: string,
 *     candidateCount?: int,
 *     maxTokens?: int,
 *     temperature?: float,
 *     topP?: float,
 *     topK?: int,
 *     stopSequences?: array<int, string>,
 *     presencePenalty?: float,
 *     frequencyPenalty?: float,
 *     logprobs?: bool,
 *     topLogprobs?: int,
 *     tools?: array<int, ToolArrayShape>,
 *     customOptions?: array<string, mixed>
 * }
 *
 * @extends AbstractDataValueObject<ModelConfigArrayShape>
 */
final class ModelConfig extends AbstractDataValueObject
{
    /**
     * @var ModalityEnum[]|null Output modalities for the model.
     */
    protected ?array $outputModalities = null;

    /**
     * @var string|null System instruction for the model.
     */
    protected ?string $systemInstruction = null;

    /**
     * @var int|null Number of response candidates to generate.
     */
    protected ?int $candidateCount = null;

    /**
     * @var int|null Maximum number of tokens to generate.
     */
    protected ?int $maxTokens = null;

    /**
     * @var float|null Temperature for randomness (0.0 to 2.0).
     */
    protected ?float $temperature = null;

    /**
     * @var float|null Top-p nucleus sampling parameter.
     */
    protected ?float $topP = null;

    /**
     * @var int|null Top-k sampling parameter.
     */
    protected ?int $topK = null;

    /**
     * @var string[]|null Stop sequences.
     */
    protected ?array $stopSequences = null;

    /**
     * @var float|null Presence penalty for reducing repetition.
     */
    protected ?float $presencePenalty = null;

    /**
     * @var float|null Frequency penalty for reducing repetition.
     */
    protected ?float $frequencyPenalty = null;

    /**
     * @var bool|null Whether to return log probabilities.
     */
    protected ?bool $logprobs = null;

    /**
     * @var int|null Number of top log probabilities to return.
     */
    protected ?int $topLogprobs = null;

    /**
     * @var Tool[]|null Tools available to the model.
     */
    protected ?array $tools = null;

    /**
     * @var array<string, mixed>|null Custom provider-specific options.
     */
    protected ?array $customOptions = null;

    /**
     * Sets the output modalities.
     *
     * @since n.e.x.t
     *
     * @param ModalityEnum[] $outputModalities The output modalities.
     * @return self For method chaining.
     */
    public function setOutputModalities(array $outputModalities): self
    {
        $this->outputModalities = $outputModalities;
        return $this;
    }

    /**
     * Gets the output modalities.
     *
     * @since n.e.x.t
     *
     * @return ModalityEnum[]|null The output modalities.
     */
    public function getOutputModalities(): ?array
    {
        return $this->outputModalities;
    }

    /**
     * Sets the system instruction.
     *
     * @since n.e.x.t
     *
     * @param string $systemInstruction The system instruction.
     * @return self For method chaining.
     */
    public function setSystemInstruction(string $systemInstruction): self
    {
        $this->systemInstruction = $systemInstruction;
        return $this;
    }

    /**
     * Gets the system instruction.
     *
     * @since n.e.x.t
     *
     * @return string|null The system instruction.
     */
    public function getSystemInstruction(): ?string
    {
        return $this->systemInstruction;
    }

    /**
     * Sets the candidate count.
     *
     * @since n.e.x.t
     *
     * @param int $candidateCount The candidate count.
     * @return self For method chaining.
     */
    public function setCandidateCount(int $candidateCount): self
    {
        $this->candidateCount = $candidateCount;
        return $this;
    }

    /**
     * Gets the candidate count.
     *
     * @since n.e.x.t
     *
     * @return int|null The candidate count.
     */
    public function getCandidateCount(): ?int
    {
        return $this->candidateCount;
    }

    /**
     * Sets the maximum tokens.
     *
     * @since n.e.x.t
     *
     * @param int $maxTokens The maximum tokens.
     * @return self For method chaining.
     */
    public function setMaxTokens(int $maxTokens): self
    {
        $this->maxTokens = $maxTokens;
        return $this;
    }

    /**
     * Gets the maximum tokens.
     *
     * @since n.e.x.t
     *
     * @return int|null The maximum tokens.
     */
    public function getMaxTokens(): ?int
    {
        return $this->maxTokens;
    }

    /**
     * Sets the temperature.
     *
     * @since n.e.x.t
     *
     * @param float $temperature The temperature.
     * @return self For method chaining.
     */
    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;
        return $this;
    }

    /**
     * Gets the temperature.
     *
     * @since n.e.x.t
     *
     * @return float|null The temperature.
     */
    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    /**
     * Sets the top-p parameter.
     *
     * @since n.e.x.t
     *
     * @param float $topP The top-p parameter.
     * @return self For method chaining.
     */
    public function setTopP(float $topP): self
    {
        $this->topP = $topP;
        return $this;
    }

    /**
     * Gets the top-p parameter.
     *
     * @since n.e.x.t
     *
     * @return float|null The top-p parameter.
     */
    public function getTopP(): ?float
    {
        return $this->topP;
    }

    /**
     * Sets the top-k parameter.
     *
     * @since n.e.x.t
     *
     * @param int $topK The top-k parameter.
     * @return self For method chaining.
     */
    public function setTopK(int $topK): self
    {
        $this->topK = $topK;
        return $this;
    }

    /**
     * Gets the top-k parameter.
     *
     * @since n.e.x.t
     *
     * @return int|null The top-k parameter.
     */
    public function getTopK(): ?int
    {
        return $this->topK;
    }

    /**
     * Sets the stop sequences.
     *
     * @since n.e.x.t
     *
     * @param string[] $stopSequences The stop sequences.
     * @return self For method chaining.
     */
    public function setStopSequences(array $stopSequences): self
    {
        $this->stopSequences = $stopSequences;
        return $this;
    }

    /**
     * Gets the stop sequences.
     *
     * @since n.e.x.t
     *
     * @return string[]|null The stop sequences.
     */
    public function getStopSequences(): ?array
    {
        return $this->stopSequences;
    }

    /**
     * Sets the presence penalty.
     *
     * @since n.e.x.t
     *
     * @param float $presencePenalty The presence penalty.
     * @return self For method chaining.
     */
    public function setPresencePenalty(float $presencePenalty): self
    {
        $this->presencePenalty = $presencePenalty;
        return $this;
    }

    /**
     * Gets the presence penalty.
     *
     * @since n.e.x.t
     *
     * @return float|null The presence penalty.
     */
    public function getPresencePenalty(): ?float
    {
        return $this->presencePenalty;
    }

    /**
     * Sets the frequency penalty.
     *
     * @since n.e.x.t
     *
     * @param float $frequencyPenalty The frequency penalty.
     * @return self For method chaining.
     */
    public function setFrequencyPenalty(float $frequencyPenalty): self
    {
        $this->frequencyPenalty = $frequencyPenalty;
        return $this;
    }

    /**
     * Gets the frequency penalty.
     *
     * @since n.e.x.t
     *
     * @return float|null The frequency penalty.
     */
    public function getFrequencyPenalty(): ?float
    {
        return $this->frequencyPenalty;
    }

    /**
     * Sets whether to return log probabilities.
     *
     * @since n.e.x.t
     *
     * @param bool $logprobs Whether to return log probabilities.
     * @return self For method chaining.
     */
    public function setLogprobs(bool $logprobs): self
    {
        $this->logprobs = $logprobs;
        return $this;
    }

    /**
     * Gets whether to return log probabilities.
     *
     * @since n.e.x.t
     *
     * @return bool|null Whether to return log probabilities.
     */
    public function getLogprobs(): ?bool
    {
        return $this->logprobs;
    }

    /**
     * Sets the number of top log probabilities to return.
     *
     * @since n.e.x.t
     *
     * @param int $topLogprobs The number of top log probabilities.
     * @return self For method chaining.
     */
    public function setTopLogprobs(int $topLogprobs): self
    {
        $this->topLogprobs = $topLogprobs;
        return $this;
    }

    /**
     * Gets the number of top log probabilities to return.
     *
     * @since n.e.x.t
     *
     * @return int|null The number of top log probabilities.
     */
    public function getTopLogprobs(): ?int
    {
        return $this->topLogprobs;
    }

    /**
     * Sets the tools.
     *
     * @since n.e.x.t
     *
     * @param Tool[] $tools The tools.
     * @return self For method chaining.
     */
    public function setTools(array $tools): self
    {
        $this->tools = $tools;
        return $this;
    }

    /**
     * Gets the tools.
     *
     * @since n.e.x.t
     *
     * @return Tool[]|null The tools.
     */
    public function getTools(): ?array
    {
        return $this->tools;
    }

    /**
     * Sets the custom options.
     *
     * @since n.e.x.t
     *
     * @param array<string, mixed> $customOptions The custom options.
     * @return self For method chaining.
     */
    public function setCustomOptions(array $customOptions): self
    {
        $this->customOptions = $customOptions;
        return $this;
    }

    /**
     * Gets the custom options.
     *
     * @since n.e.x.t
     *
     * @return array<string, mixed>|null The custom options.
     */
    public function getCustomOptions(): ?array
    {
        return $this->customOptions;
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     */
    public static function getJsonSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'outputModalities' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                        'enum' => ModalityEnum::getValues(),
                    ],
                    'description' => 'Output modalities for the model.',
                ],
                'systemInstruction' => [
                    'type' => 'string',
                    'description' => 'System instruction for the model.',
                ],
                'candidateCount' => [
                    'type' => 'integer',
                    'minimum' => 1,
                    'description' => 'Number of response candidates to generate.',
                ],
                'maxTokens' => [
                    'type' => 'integer',
                    'minimum' => 1,
                    'description' => 'Maximum number of tokens to generate.',
                ],
                'temperature' => [
                    'type' => 'number',
                    'minimum' => 0.0,
                    'maximum' => 2.0,
                    'description' => 'Temperature for randomness.',
                ],
                'topP' => [
                    'type' => 'number',
                    'minimum' => 0.0,
                    'maximum' => 1.0,
                    'description' => 'Top-p nucleus sampling parameter.',
                ],
                'topK' => [
                    'type' => 'integer',
                    'minimum' => 1,
                    'description' => 'Top-k sampling parameter.',
                ],
                'stopSequences' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'description' => 'Stop sequences.',
                ],
                'presencePenalty' => [
                    'type' => 'number',
                    'description' => 'Presence penalty for reducing repetition.',
                ],
                'frequencyPenalty' => [
                    'type' => 'number',
                    'description' => 'Frequency penalty for reducing repetition.',
                ],
                'logprobs' => [
                    'type' => 'boolean',
                    'description' => 'Whether to return log probabilities.',
                ],
                'topLogprobs' => [
                    'type' => 'integer',
                    'minimum' => 1,
                    'description' => 'Number of top log probabilities to return.',
                ],
                'tools' => [
                    'type' => 'array',
                    'items' => Tool::getJsonSchema(),
                    'description' => 'Tools available to the model.',
                ],
                'customOptions' => [
                    'type' => 'object',
                    'additionalProperties' => true,
                    'description' => 'Custom provider-specific options.',
                ],
            ],
            'additionalProperties' => false,
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     *
     * @return ModelConfigArrayShape
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->outputModalities !== null) {
            $data['outputModalities'] = array_values(array_map(static function (ModalityEnum $modality): string {
                return $modality->value;
            }, $this->outputModalities));
        }

        if ($this->systemInstruction !== null) {
            $data['systemInstruction'] = $this->systemInstruction;
        }

        if ($this->candidateCount !== null) {
            $data['candidateCount'] = $this->candidateCount;
        }

        if ($this->maxTokens !== null) {
            $data['maxTokens'] = $this->maxTokens;
        }

        if ($this->temperature !== null) {
            $data['temperature'] = $this->temperature;
        }

        if ($this->topP !== null) {
            $data['topP'] = $this->topP;
        }

        if ($this->topK !== null) {
            $data['topK'] = $this->topK;
        }

        if ($this->stopSequences !== null) {
            $data['stopSequences'] = array_values($this->stopSequences);
        }

        if ($this->presencePenalty !== null) {
            $data['presencePenalty'] = $this->presencePenalty;
        }

        if ($this->frequencyPenalty !== null) {
            $data['frequencyPenalty'] = $this->frequencyPenalty;
        }

        if ($this->logprobs !== null) {
            $data['logprobs'] = $this->logprobs;
        }

        if ($this->topLogprobs !== null) {
            $data['topLogprobs'] = $this->topLogprobs;
        }

        if ($this->tools !== null) {
            $data['tools'] = array_values(array_map(static function (Tool $tool): array {
                return $tool->toArray();
            }, $this->tools));
        }

        if ($this->customOptions !== null) {
            $data['customOptions'] = $this->customOptions;
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     */
    public static function fromArray(array $array): self
    {
        $config = new self();

        if (isset($array['outputModalities'])) {
            $config->setOutputModalities(array_map(
                static fn(string $modality): ModalityEnum => ModalityEnum::from($modality),
                $array['outputModalities']
            ));
        }

        if (isset($array['systemInstruction'])) {
            $config->setSystemInstruction($array['systemInstruction']);
        }

        if (isset($array['candidateCount'])) {
            $config->setCandidateCount($array['candidateCount']);
        }

        if (isset($array['maxTokens'])) {
            $config->setMaxTokens($array['maxTokens']);
        }

        if (isset($array['temperature'])) {
            $config->setTemperature($array['temperature']);
        }

        if (isset($array['topP'])) {
            $config->setTopP($array['topP']);
        }

        if (isset($array['topK'])) {
            $config->setTopK($array['topK']);
        }

        if (isset($array['stopSequences'])) {
            $config->setStopSequences(array_values($array['stopSequences']));
        }

        if (isset($array['presencePenalty'])) {
            $config->setPresencePenalty($array['presencePenalty']);
        }

        if (isset($array['frequencyPenalty'])) {
            $config->setFrequencyPenalty($array['frequencyPenalty']);
        }

        if (isset($array['logprobs'])) {
            $config->setLogprobs($array['logprobs']);
        }

        if (isset($array['topLogprobs'])) {
            $config->setTopLogprobs($array['topLogprobs']);
        }

        if (isset($array['tools'])) {
            $config->setTools(array_map(static function (array $toolData): Tool {
                return Tool::fromArray($toolData);
            }, $array['tools']));
        }

        if (isset($array['customOptions'])) {
            $config->setCustomOptions($array['customOptions']);
        }

        return $config;
    }
}
