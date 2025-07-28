<?php

declare(strict_types=1);

namespace WordPress\AiClient\Common;

use JsonSerializable;
use stdClass;
use WordPress\AiClient\Common\Contracts\WithArrayTransformationInterface;
use WordPress\AiClient\Common\Contracts\WithJsonSchemaInterface;

/**
 * Abstract base class for all Data Value Objects in the AI Client.
 *
 * This abstract class consolidates the common functionality needed by all
 * data transfer objects:
 * - Array transformation for data manipulation
 * - JSON schema support for validation and documentation
 * - JSON serialization with proper empty object handling
 *
 * All DTOs in the AI Client should extend this class to ensure
 * consistent behavior across the codebase.
 *
 * @since n.e.x.t
 *
 * @template TArrayShape of array<string, mixed>
 * @implements WithArrayTransformationInterface<TArrayShape>
 */
abstract class AbstractDataValueObject implements
    WithArrayTransformationInterface,
    WithJsonSchemaInterface,
    JsonSerializable
{
    /**
     * Converts the object to a JSON-serializable format.
     *
     * This method uses the toArray() method and then processes the result
     * based on the JSON schema to ensure proper object representation for
     * empty arrays.
     *
     * @since n.e.x.t
     *
     * @return mixed The JSON-serializable representation.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $data = $this->toArray();
        $schema = static::getJsonSchema();

        return $this->convertEmptyArraysToObjects($data, $schema);
    }

    /**
     * Recursively converts empty arrays to stdClass objects where the schema expects objects.
     *
     * @since n.e.x.t
     *
     * @param mixed $data The data to process.
     * @param array<mixed, mixed> $schema The JSON schema for the data.
     * @return mixed The processed data.
     */
    private function convertEmptyArraysToObjects($data, array $schema)
    {
        // If data is an empty array and schema expects object, convert to stdClass
        if (is_array($data) && empty($data) && isset($schema['type']) && $schema['type'] === 'object') {
            return new stdClass();
        }

        // If data is an array with content, recursively process nested structures
        if (is_array($data)) {
            // Handle object properties
            if (isset($schema['properties']) && is_array($schema['properties'])) {
                foreach ($data as $key => $value) {
                    if (isset($schema['properties'][$key]) && is_array($schema['properties'][$key])) {
                        $data[$key] = $this->convertEmptyArraysToObjects($value, $schema['properties'][$key]);
                    }
                }
            }

            // Handle array items
            if (isset($schema['items']) && is_array($schema['items'])) {
                foreach ($data as $index => $item) {
                    $data[$index] = $this->convertEmptyArraysToObjects($item, $schema['items']);
                }
            }

            // Handle oneOf schemas - just use the first one
            if (isset($schema['oneOf']) && is_array($schema['oneOf'])) {
                foreach ($schema['oneOf'] as $possibleSchema) {
                    if (is_array($possibleSchema)) {
                        return $this->convertEmptyArraysToObjects($data, $possibleSchema);
                    }
                }
            }
        }

        return $data;
    }
}
