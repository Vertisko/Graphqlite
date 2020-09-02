<?php declare(strict_types=1);

namespace App\Types\URL;

use GraphQL\Type\Definition\InputType;
use GraphQL\Type\Definition\NamedType;
use GraphQL\Type\Definition\OutputType;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Scalar;
use ReflectionMethod;
use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperInterface;

class UrlTypeMapper implements RootTypeMapperInterface
{
    private RootTypeMapperInterface $next;

    /**
     * UrlTypeMapper constructor.
     *
     * @param RootTypeMapperInterface $next
     */
    public function __construct(RootTypeMapperInterface $next)
    {
        $this->next = $next;
    }

    /**
     * @inheritDoc
     * @phpcsSuppress SlevomatCodingStandard.Commenting.UselessInheritDocComment
     */
    public function toGraphQLOutputType(Type $type, ?OutputType $subType, ReflectionMethod $refMethod, DocBlock $docBlockObj): OutputType
    {
        if ($type instanceof Scalar) {
            return UrlType::getInstance();
        }

        return $this->next->toGraphQLOutputType($type, $subType, $refMethod, $docBlockObj);
    }

    /**
     * @inheritDoc
     * @phpcsSuppress SlevomatCodingStandard.Commenting.UselessInheritDocComment
     */
    public function toGraphQLInputType(Type $type, ?InputType $subType, string $argumentName, ReflectionMethod $refMethod, DocBlock $docBlockObj): InputType
    {
        if ($type instanceof Scalar) {
            return UrlType::getInstance();
        }

        return $this->next->toGraphQLInputType($type, $subType, $argumentName, $refMethod, $docBlockObj);
    }

    /**
     * Returns a GraphQL type by name.
     * If this root type mapper can return this type in "toGraphQLOutputType" or "toGraphQLInputType", it should
     * also map these types by name in the "mapNameToType" method.
     *
     * @param string $typeName The name of the GraphQL type
     * @return NamedType
     */
    public function mapNameToType(string $typeName): NamedType
    {
        if ($typeName === UrlType::NAME) {
            return UrlType::getInstance();
        }

        return $this->next->mapNameToType($typeName);
    }
}
