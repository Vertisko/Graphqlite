<?php declare(strict_types=1);

namespace App\Types\Enums;

use MyCLabs\Enum\Enum;

class Drm extends Enum
{
    public const FAIRPLAY = 'FAIRPLAY';
    public const PLAYREADY = 'PLAYREADY';
    public const WIDEVINE = 'WIDEVINE';
}
