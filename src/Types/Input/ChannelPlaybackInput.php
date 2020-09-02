<?php declare(strict_types=1);

namespace App\Types\Input;

use App\Types\Enums\AudioFormat;
use App\Types\Enums\Drm;
use App\Types\Enums\Quality;
use App\Types\Enums\StreamFormat;
use App\Types\Enums\VideoFormat;

class ChannelPlaybackInput
{
    private StreamFormat $streamFormat;

    /**
     * @var VideoFormat[]
     */
    private array $videoFormats;

    /**
     * @var AudioFormat[]
     */
    private array $audioFormats;

    private Drm $drm;

    private bool $abrNotSupported;

    private Quality $maxQuality;

    /**
     * ChannelPlaybackInput constructor.
     *
     * @param StreamFormat $streamFormat
     * @param VideoFormat[] $videoFormats
     * @param AudioFormat[] $audioFormats
     * @param Drm $drm
     * @param bool $abrNotSupported
     * @param Quality $maxQuality
     */
    public function __construct(
        StreamFormat $streamFormat, array $videoFormats, array $audioFormats, Drm $drm, bool $abrNotSupported, Quality $maxQuality)
    {
        $this->streamFormat = $streamFormat;
        $this->videoFormats = $videoFormats;
        $this->audioFormats = $audioFormats;
        $this->drm = $drm;
        $this->abrNotSupported = $abrNotSupported;
        $this->maxQuality = $maxQuality;
    }

    /**
     * @return StreamFormat
     */
    public function getStreamFormat(): StreamFormat
    {
        return $this->streamFormat;
    }

    /**
     * @param StreamFormat $streamFormat
     */
    public function setStreamFormat(StreamFormat $streamFormat): void
    {
        $this->streamFormat = $streamFormat;
    }

    /**
     * @return array
     */
    public function getVideoFormats(): array
    {
        return $this->videoFormats;
    }

    /**
     * @param array $videoFormats
     */
    public function setVideoFormats(array $videoFormats): void
    {
        $this->videoFormats = $videoFormats;
    }

    /**
     * @return array
     */
    public function getAudioFormats(): array
    {
        return $this->audioFormats;
    }

    /**
     * @param array $audioFormats
     */
    public function setAudioFormats(array $audioFormats): void
    {
        $this->audioFormats = $audioFormats;
    }

    /**
     * @return Drm
     */
    public function getDrm(): Drm
    {
        return $this->drm;
    }

    /**
     * @param Drm $drm
     */
    public function setDrm(Drm $drm): void
    {
        $this->drm = $drm;
    }

    /**
     * @return bool
     */
    public function isAbrNotSupported(): bool
    {
        return $this->abrNotSupported;
    }

    /**
     * @param bool $abrNotSupported
     */
    public function setAbrNotSupported(bool $abrNotSupported): void
    {
        $this->abrNotSupported = $abrNotSupported;
    }

    /**
     * @return Quality
     */
    public function getMaxQuality(): Quality
    {
        return $this->maxQuality;
    }

    /**
     * @param Quality $maxQuality
     */
    public function setMaxQuality(Quality $maxQuality): void
    {
        $this->maxQuality = $maxQuality;
    }
}
