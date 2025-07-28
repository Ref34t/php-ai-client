<?php

declare(strict_types=1);

namespace WordPress\AiClient\Common\Contracts;

use JsonSerializable;

/**
 * Interface for objects that support JSON serialization and deserialization.
 *
 * @since 1.0.0
 *
 * @template TJsonShape of array<string, mixed>
 */
interface WithJsonSerialization extends JsonSerializable
{
    /**
     * Creates an instance from JSON data.
     *
     * @since 1.0.0
     *
     * @param TJsonShape $json The JSON data.
     * @return static The created instance.
     */
    public static function fromJson(array $json);
}
