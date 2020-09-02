<?php declare(strict_types=1);

namespace App\Types;

interface TypeInterface
{
    /**
     * @return TypeInterface
     */
    public static function getInstance(): self;
}
