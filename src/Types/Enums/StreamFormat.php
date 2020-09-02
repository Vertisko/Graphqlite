<?php declare(strict_types=1);

namespace App\Types\Enums;

use MyCLabs\Enum\Enum;

/**
 * @template T
 */
class StreamFormat extends Enum
{
    public const M3U8 = 'M3U8';
    public const DASH = 'DASH';
}
