<?php

declare(strict_types=1);

namespace WordPress\AiClient\Providers\Models\DTO;

use WordPress\AiClient\Common\AbstractDataValueObject;

/**
 * Represents a required configuration option for an AI model.
 *
 * This class defines an option that must be set when using a model,
 * including its name and the required value.
 *
 * @since n.e.x.t
 *
 * @phpstan-type RequiredOptionArrayShape array{
 *     name: string,
 *     value: mixed
 * }
 *
 * @extends AbstractDataValueObject<RequiredOptionArrayShape>
 */
final class RequiredOption extends AbstractDataValueObject
{
    /**
     * @var string The option name.
     */
    protected string $name;

    /**
     * @var mixed The required value.
     */
    protected $value;

    /**
     * Constructor.
     *
     * @since n.e.x.t
     *
     * @param string $name The option name.
     * @param mixed $value The required value.
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Gets the option name.
     *
     * @since n.e.x.t
     *
     * @return string The option name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the required value.
     *
     * @since n.e.x.t
     *
     * @return mixed The required value.
     */
    public function getValue()
    {
        return $this->value;
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
                'name' => [
                    'type' => 'string',
                    'description' => 'The option name.',
                ],
                'value' => [
                    'oneOf' => [
                        ['type' => 'string'],
                        ['type' => 'number'],
                        ['type' => 'boolean'],
                        ['type' => 'null'],
                        ['type' => 'array'],
                        ['type' => 'object'],
                    ],
                    'description' => 'The required value.',
                ],
            ],
            'required' => ['name', 'value'],
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     *
     * @return RequiredOptionArrayShape
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }

    /**
     * {@inheritDoc}
     *
     * @since n.e.x.t
     */
    public static function fromArray(array $array): self
    {
        return new self(
            $array['name'],
            $array['value']
        );
    }
}
