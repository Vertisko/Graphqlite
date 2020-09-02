<?php declare(strict_types=1);

namespace App\Entity\DTO;

use App\Types\Enums\VideoFormat;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
class ChannelPlayback
{
    private string $url;

    private \DateTimeImmutable $expiration;

    private string $licenseData;

    /** @var VideoFormat[] */
    private array $videoFormats;

    /** @var Cue[] */
    private array $cues;

    private int $watchingStateOffset;

    /**
     * @param string $url
     * @param \DateTimeImmutable $expiration
     * @param string $licenseData
     * @param VideoFormat[] $videoFormats
     * @param int $milliseconds
     * @return ChannelPlayback
     */
    public static function create(string $url,
                                  \DateTimeImmutable $expiration,
                                  string $licenseData,
                                  array $videoFormats,
                                  int $milliseconds
    ): ChannelPlayback
    {
        $channelPlayback = new self();
        $channelPlayback->cues = [];
        $channelPlayback->url = $url;
        $channelPlayback->expiration = $expiration;
        $channelPlayback->licenseData = $licenseData;
        $channelPlayback->videoFormats = $videoFormats;
        $channelPlayback->watchingStateOffset = $milliseconds;

        return $channelPlayback;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getExpiration(): \DateTimeImmutable
    {
        return $this->expiration;
    }

    /**
     * @param \DateTimeImmutable $expiration
     */
    public function setExpiration(\DateTimeImmutable $expiration): void
    {
        $this->expiration = $expiration;
    }

    /**
     * @return string
     */
    public function getLicenseData(): string
    {
        return $this->licenseData;
    }

    /**
     * @param string $licenseData
     */
    public function setLicenseData(string $licenseData): void
    {
        $this->licenseData = $licenseData;
    }

    /**
     * @Field()
     * @return VideoFormat[]
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
     * @return Cue[]
     */
    public function getCues(): array
    {
        return $this->cues;
    }

    /**
     * @param Cue $cue
     */
    public function addCue(Cue $cue): void
    {
        $this->cues[] = $cue;
    }

    /**
     * @param Cue[] $cues
     */
    public function setCues(array $cues): void
    {
        $this->cues = $cues;
    }

    /**
     * @Field(outputType="Milliseconds")
     * @return int
     */
    public function getWatchingStateOffset(): int
    {
        return $this->watchingStateOffset;
    }

    /**
     * @param int $watchingStateOffset
     */
    public function setWatchingStateOffset(int $watchingStateOffset): void
    {
        $this->watchingStateOffset = $watchingStateOffset;
    }

    /**
     * @Field(outputType="URL")
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
