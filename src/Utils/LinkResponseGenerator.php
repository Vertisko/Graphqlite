<?php declare(strict_types=1);

namespace App\Utils;

use App\Entity\DTO\ChannelPlayback;
use App\Entity\DTO\Cue;
use App\Types\Enums\AudioFormat;
use App\Types\Enums\VideoFormat;

class LinkResponseGenerator
{
    /**
     * @param string $channelId
     * @param string $profileId
     * @param string $streamFormat
     * @param VideoFormat[] $videoFormats
     * @param AudioFormat[] $audioFormats
     * @param bool $abrNotSupported
     * @param string $drm
     * @return ChannelPlayback
     */
    public static function generate(string $channelId, string $profileId, string $streamFormat, array $videoFormats, array $audioFormats, bool $abrNotSupported, string $drm): ChannelPlayback
    {
        $urlOffset = $channelId . $profileId . $streamFormat . \implode(',', $videoFormats) . \implode(
            ',',
            $audioFormats,
        ) . (string) $abrNotSupported. $drm;

        $videoFormat = new VideoFormat(VideoFormat::H264);

        $channelPlayback = ChannelPlayback::create(
            'stream.lstv.en/live/nova-sport/master.m3u8?'. $urlOffset,
            new \DateTimeImmutable('2020-12-9 10:00:00'),
            'hash3q3232',
            [$videoFormat],
            10,
        );

        $channelPlayback->addCue(Cue::create('UP', 'FILL', 'loving it', 10));

        return $channelPlayback;
    }
}
