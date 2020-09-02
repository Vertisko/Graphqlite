<?php declare(strict_types=1);

namespace App\Types\Timezone;

use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperFactoryContext;
use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperFactoryInterface;
use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperInterface;

class TimezoneMapperFactory implements RootTypeMapperFactoryInterface
{
    /**
     * @param RootTypeMapperInterface $next
     * @param RootTypeMapperFactoryContext $context
     * @return RootTypeMapperInterface
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function create(RootTypeMapperInterface $next, RootTypeMapperFactoryContext $context): RootTypeMapperInterface
    {
        return new TimezoneMapper($next);
    }
}
