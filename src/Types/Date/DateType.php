<?php declare(strict_types=1);

namespace App\Types\Date;

use App\Types\TypeInterface;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

class DateType extends ScalarType implements TypeInterface
{
    public const NAME = 'Date';

    private static ?self $instance = null;

    /**
     * MillisecondsType constructor.
     */
    public function __construct()
    {
        $config = [];
        $config['name'] = self::NAME;
        $config['description'] = 'Date in YYYY-MM-DD format';

        parent::__construct($config);
    }

    /**
     * @return DateType
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
        $format = 'Y-m-d';
        $datetime = \DateTime::createFromFormat($format, $value);

        if ($datetime === false || $datetime->format($format) !== $value) {
            throw new Error("Cannot represent value as Date: " . Utils::printSafe($value));
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
        if (!($valueNode instanceof StringValueNode)) {
            throw new Error('Query error: Can only parse string');
        }

        return (string) $valueNode->value;
    }
}
