<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Models\Enums;

use WordPress\AiClient\Common\AbstractEnum;

/**
 * Enum for model options
 *
 * @since n.e.x.t
 *
 * @method static self inputModalities() Create an instance for INPUT_MODALITIES option
 * @method static self outputModalities() Create an instance for OUTPUT_MODALITIES option
 * @method static self systemInstruction() Create an instance for SYSTEM_INSTRUCTION option
 * @method static self candidateCount() Create an instance for CANDIDATE_COUNT option
 * @method static self maxTokens() Create an instance for MAX_TOKENS option
 * @method static self temperature() Create an instance for TEMPERATURE option
 * @method static self topK() Create an instance for TOP_K option
 * @method static self topP() Create an instance for TOP_P option
 * @method static self outputMimeType() Create an instance for OUTPUT_MIME_TYPE option
 * @method static self outputSchema() Create an instance for OUTPUT_SCHEMA option
 * @method bool isInputModalities() Check if the option is INPUT_MODALITIES
 * @method bool isOutputModalities() Check if the option is OUTPUT_MODALITIES
 * @method bool isSystemInstruction() Check if the option is SYSTEM_INSTRUCTION
 * @method bool isCandidateCount() Check if the option is CANDIDATE_COUNT
 * @method bool isMaxTokens() Check if the option is MAX_TOKENS
 * @method bool isTemperature() Check if the option is TEMPERATURE
 * @method bool isTopK() Check if the option is TOP_K
 * @method bool isTopP() Check if the option is TOP_P
 * @method bool isOutputMimeType() Check if the option is OUTPUT_MIME_TYPE
 * @method bool isOutputSchema() Check if the option is OUTPUT_SCHEMA
 */
class OptionEnum extends AbstractEnum
{
    /**
     * Input modalities option
     */
    public const INPUT_MODALITIES = 'input_modalities';

    /**
     * Output modalities option
     */
    public const OUTPUT_MODALITIES = 'output_modalities';

    /**
     * System instruction option
     */
    public const SYSTEM_INSTRUCTION = 'system_instruction';

    /**
     * Candidate count option
     */
    public const CANDIDATE_COUNT = 'candidate_count';

    /**
     * Maximum tokens option
     */
    public const MAX_TOKENS = 'max_tokens';

    /**
     * Temperature option
     */
    public const TEMPERATURE = 'temperature';

    /**
     * Top K option
     */
    public const TOP_K = 'top_k';

    /**
     * Top P option
     */
    public const TOP_P = 'top_p';

    /**
     * Output MIME type option
     */
    public const OUTPUT_MIME_TYPE = 'output_mime_type';

    /**
     * Output schema option
     */
    public const OUTPUT_SCHEMA = 'output_schema';
}
