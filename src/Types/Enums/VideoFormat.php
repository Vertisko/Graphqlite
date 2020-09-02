<?php declare(strict_types=1);

namespace App\Types\Enums;

use MyCLabs\Enum\Enum;

class VideoFormat extends Enum
{
    public const H264 = 'H264';
    public const H265 = 'H265';
}
