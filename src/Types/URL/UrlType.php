<?php declare(strict_types=1);

namespace App\Types\URL;

use App\Types\TypeInterface;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

class UrlType extends ScalarType implements TypeInterface
{
    public const NAME = 'URL';

    private static ?self $instance = null;

    /**
     * UrlType constructor.
     */
    public function __construct()
    {
        $config = [];
        $config['name'] = self::NAME;

        parent::__construct($config);
    }

    /**
     * @return UrlType
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
        if (
            !\is_string($value)
            || !\filter_var($value, \FILTER_VALIDATE_URL)
        ) { // quite naive, but after all this is example
            throw new Error("Cannot represent value as URL: " . Utils::printSafe($value));
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     *
     *  @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        if (!($valueNode instanceof StringValueNode)) {
            throw new Error('Query error: Can only parse string');
        }

        $value = $valueNode->value;

        if (!\is_string($value) || !\filter_var($value, \FILTER_VALIDATE_URL)) {
            throw new Error('Query error: Not a valid URL');
        }

        return $value;
    }
}
