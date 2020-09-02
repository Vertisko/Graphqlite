<?php declare(strict_types=1);

namespace App\Types\Input\Factory;

use App\Types\Enums\AudioFormat;
use App\Types\Enums\Drm;
use App\Types\Enums\Quality;
use App\Types\Enums\StreamFormat;
use App\Types\Enums\VideoFormat;
use App\Types\Input\ChannelPlaybackInput;
use TheCodingMachine\GraphQLite\Annotations\Factory;

class ChannelPlaybackInputFactory
{
    /**
     * @Factory(name="ChannelPlaybackInput", default=true)
     * ChannelPlaybackInput constructor.
     * @param StreamFormat $streamFormat
     * @param VideoFormat[] $videoFormats
     * @param AudioFormat[] $audioFormats
     * @param Drm $drm
     * @param bool $abrNotSupported
     * @param Quality $maxQuality
     * @return ChannelPlaybackInput
     */
    public static function createChannelPlaybackInput(StreamFormat $streamFormat, array $videoFormats, array $audioFormats, Drm $drm, bool $abrNotSupported, Quality $maxQuality
    ): ChannelPlaybackInput
    {
        return new ChannelPlaybackInput(
            $streamFormat,
            $videoFormats,
            $audioFormats,
            $drm,
            $abrNotSupported,
            $maxQuality,
        );
    }
}
