<?php declare(strict_types=1);

namespace App\Types\Milliseconds;

use App\Types\TypeInterface;
use GraphQL\Error\Error;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

class MillisecondsType extends ScalarType implements TypeInterface
{
    public const NAME = 'Milliseconds';

    private static ?self $instance = null;

    /**
     * MillisecondsType constructor.
     */
    public function __construct()
    {
        $config = [];
        $config['name'] = self::NAME;
        $config['description'] = 'Positive integer, representing milliseconds';

        parent::__construct($config);
    }

    /**
     * @return MillisecondsType
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Serializes an internal value to include in a response.
     *
     * @param mixed $value
     * @return mixed
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     * @return mixed
     * @throws Error
     */
    public function parseValue($value)
    {
        if (!\is_int($value) || $value < 0) {
            throw new Error("Cannot represent value as Milliseconds: " . Utils::printSafe($value));
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        if (!($valueNode instanceof IntValueNode)) {
            throw new Error('Query error: Can only parse int');
        }

        $value = (int) $valueNode->value;
        if (!\is_int($value) || $value < 0) {
            throw new Error('Query error, invalid milliseconds');
        }

        return $value;
    }
}
