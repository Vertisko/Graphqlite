<?php declare(strict_types=1);

namespace App\Types\Enums;

use MyCLabs\Enum\Enum;

class Quality extends Enum
{
    public const HD = 'HD';
    public const SD = 'SD';
    public const FHD = 'FHD';
    public const UHD = 'UHD';
}
