<?php

declare(strict_types=1);

namespace WordPress\AiClient\Common;

use BadMethodCallException;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Abstract base class for enum-like behavior in PHP 7.4
 *
 * This class provides enum-like functionality for PHP versions that don't support native enums.
 * Child classes should define uppercase snake_case constants for enum values.
 *
 * @example
 * class PersonEnum extends AbstractEnum {
 *     public const FIRST_NAME = 'first';
 *     public const LAST_NAME = 'last';
 * }
 *
 * // Usage:
 * $enum = PersonEnum::firstName(); // Creates instance with value 'first'
 * $enum->isFirstName(); // Returns true
 * $enum->equals('first'); // Returns true
 * $enum->is(PersonEnum::firstName()); // Returns true
 */
abstract class AbstractEnum
{
    /**
     * @var string|int|float The value of the enum instance
     */
    private $value;

    /**
     * @var array<string, array<string, string|int|float>> Cache for reflection data
     */
    private static $cache = [];

    /**
     * Constructor is private to ensure instances are created through static methods
     *
     * @param string|int|float $value The enum value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get the value of the enum instance
     *
     * @return string|int|float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Check if this enum has the same value as the given value
     *
     * @param string|int|float|self $other The value or enum to compare
     * @return bool
     */
    public function equals($other): bool
    {
        if ($other instanceof self) {
            return $this->is($other);
        }

        return $this->value === $other;
    }

    /**
     * Check if this enum is the same instance type and value as another enum
     *
     * @param self $other The other enum to compare
     * @return bool
     */
    public function is(self $other): bool
    {
        return get_class($this) === get_class($other) && $this->value === $other->getValue();
    }

    /**
     * Get all valid values for this enum
     *
     * @return array<string, string|int|float>
     */
    public static function getValues(): array
    {
        return self::getConstants();
    }

    /**
     * Check if a value is valid for this enum
     *
     * @param string|int|float $value The value to check
     * @return bool
     */
    public static function isValidValue($value): bool
    {
        return in_array($value, self::getValues(), true);
    }

    /**
     * Create an enum instance from a value
     *
     * @param string|int|float $value The enum value
     * @return static
     * @throws InvalidArgumentException If the value is not valid
     */
    public static function fromValue($value): self
    {
        if (!self::isValidValue($value)) {
            throw new InvalidArgumentException(
                sprintf('Invalid value "%s" for enum %s', (string) $value, static::class)
            );
        }

        $className = static::class;
        return new $className($value);
    }

    /**
     * Get all constants for this enum class
     *
     * @return array<string, string|int|float>
     */
    protected static function getConstants(): array
    {
        $className = static::class;

        if (!isset(self::$cache[$className])) {
            $reflection = new ReflectionClass($className);
            $constants = $reflection->getConstants();

            // Filter to only include uppercase snake_case constants
            $enumConstants = [];
            foreach ($constants as $name => $value) {
                if (
                    preg_match('/^[A-Z][A-Z0-9_]*$/', $name)
                    && (is_string($value) || is_int($value) || is_float($value))
                ) {
                    $enumConstants[$name] = $value;
                }
            }

            self::$cache[$className] = $enumConstants;
        }

        return self::$cache[$className];
    }

    /**
     * Handle dynamic method calls for enum creation and checking
     *
     * @param string $name The method name
     * @param array<mixed> $arguments The method arguments
     * @return bool
     * @throws BadMethodCallException If the method doesn't exist
     */
    public function __call(string $name, array $arguments)
    {
        // Handle is* methods
        if (strpos($name, 'is') === 0) {
            $constantName = self::camelCaseToConstant(substr($name, 2));
            $constants = self::getConstants();

            if (isset($constants[$constantName])) {
                return $this->value === $constants[$constantName];
            }
        }

        throw new BadMethodCallException(
            sprintf('Method %s::%s does not exist', static::class, $name)
        );
    }

    /**
     * Handle static method calls for enum creation
     *
     * @param string $name The method name
     * @param array<mixed> $arguments The method arguments
     * @return static
     * @throws BadMethodCallException If the method doesn't exist
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $constantName = self::camelCaseToConstant($name);
        $constants = self::getConstants();

        if (isset($constants[$constantName])) {
            $className = static::class;
            return new $className($constants[$constantName]);
        }

        throw new BadMethodCallException(
            sprintf('Method %s::%s does not exist', static::class, $name)
        );
    }

    /**
     * Convert camelCase to CONSTANT_CASE
     *
     * @param string $camelCase The camelCase string
     * @return string The CONSTANT_CASE version
     */
    private static function camelCaseToConstant(string $camelCase): string
    {
        $snakeCase = preg_replace('/([a-z])([A-Z])/', '$1_$2', $camelCase);
        if ($snakeCase === null) {
            return strtoupper($camelCase);
        }
        return strtoupper($snakeCase);
    }

    /**
     * String representation of the enum
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
