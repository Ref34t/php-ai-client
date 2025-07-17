<?php

declare(strict_types=1);

namespace WordPress\AiClient\Messages\Enums;

use WordPress\AiClient\Common\AbstractEnum;

/**
 * Enum for input/output modalities
 *
 * @method static self text() Create an instance for TEXT modality
 * @method static self document() Create an instance for DOCUMENT modality
 * @method static self image() Create an instance for IMAGE modality
 * @method static self audio() Create an instance for AUDIO modality
 * @method static self video() Create an instance for VIDEO modality
 * @method bool isText() Check if the modality is TEXT
 * @method bool isDocument() Check if the modality is DOCUMENT
 * @method bool isImage() Check if the modality is IMAGE
 * @method bool isAudio() Check if the modality is AUDIO
 * @method bool isVideo() Check if the modality is VIDEO
 */
class ModalityEnum extends AbstractEnum
{
    /**
     * Text modality
     */
    public const TEXT = 'text';

    /**
     * Document modality (PDFs, Word docs, etc.)
     */
    public const DOCUMENT = 'document';

    /**
     * Image modality
     */
    public const IMAGE = 'image';

    /**
     * Audio modality
     */
    public const AUDIO = 'audio';

    /**
     * Video modality
     */
    public const VIDEO = 'video';
}
