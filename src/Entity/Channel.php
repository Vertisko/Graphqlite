<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\ExternalEntityInterface;
use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\TimestampAbleInterface;
use App\Entity\Traits\ExternalEntityTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampAbleTrait;
use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 * @ORM\Entity(repositoryClass=ChannelRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Channel implements IdInterface, TimestampAbleInterface, ExternalEntityInterface
{
    use IdTrait;
    use TimestampAbleTrait;
    use ExternalEntityTrait;

    /**
     * @ORM\Column(type="boolean", options={"default":"1"})
     */
    private bool $activated = true;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * LSTV-DB-API NAME
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $externalName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $logoUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $parentalRating;

    /**
     * How many minutes backwards, it's possible to play back content
     *
     * @ORM\Column(type="integer")
     */
    private int $timeShiftSlidingWindow;

    /**
     * @ORM\ManyToOne(targetEntity=ChannelGroup::class)
     */
    private ChannelGroup $channelGroup;

    /**
     * DC API ID
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private string $dcApiId;

    /**
     * @ORM\Column(type="datetimetz_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $lastUpdate;

    /**
     * @ORM\Column(type="datetimetz_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $lastSynchronization;

    /**
     * @var Collection<int,EpgEvent>
     * @ORM\OneToMany(targetEntity=EpgEvent::class, mappedBy="channel")
     * @ORM\OrderBy({"start" = "ASC"})
     */
    private Collection $epgEvents;

    /**
     * Channel constructor.
     */
    public function __construct()
    {
        $this->epgEvents = new ArrayCollection();
    }

    /**
     * @param ChannelGroup $channelGroup
     * @param string $name
     * @param string $logoUrl
     * @param int $timeShiftSlidingWindow
     * @param string $dcApiId
     * @param int|null $parentalRating
     * @param string|null $description
     * @param bool|null $activated
     * @param string|null $externalId
     * @param string|null $externalName
     * @return Channel
     */
    public static function create(ChannelGroup $channelGroup,
                                  string $name,
                                  string $logoUrl,
                                  int $timeShiftSlidingWindow,
                                  string $dcApiId,
                                  ?int $parentalRating = null,
                                  ?string $description = null,
                                  ?bool $activated = null,
                                  ?string $externalId = null,
                                  ?string $externalName = null): Channel
    {
        $channel = new self();
        $channel->setId();
        $channel->setChannelGroup($channelGroup);
        $channel->setName($name);
        $channel->setExternalName($externalName);
        $channel->setDescription($description);
        $channel->setExternalId($externalId);
        $channel->setDcApiId($dcApiId);
        $channel->setParentalRating($parentalRating);
        $channel->setTimeShiftSlidingWindow($timeShiftSlidingWindow);
        $channel->setLogoUrl($logoUrl);
        $channel->setName($name);

        if (!\is_null($activated)) {
            $channel->setActivated($activated);
        }

        return $channel;
    }

    /**
     * @Field()
     * @return bool|null
     */
    public function isActivated(): ?bool
    {
        return $this->activated;
    }

    /**
     * @param bool $activated
     */
    public function setActivated(bool $activated): void
    {
        $this->activated = $activated;
    }

    /**
     * @Field(outputType="URL")
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @Field()
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @Field()
     * @return string|null
     */
    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    /**
     * @param string $logoUrl
     */
    public function setLogoUrl(string $logoUrl): void
    {
        $this->logoUrl = $logoUrl;
    }

    /**
     * @Field()
     * @return int|null
     */
    public function getParentalRating(): ?int
    {
        return $this->parentalRating;
    }

    /**
     * @param int|null $parentalRating
     */
    public function setParentalRating(?int $parentalRating): void
    {
        $this->parentalRating = $parentalRating;
    }

    /**
     * @return int|null
     */
    public function getTimeShiftSlidingWindow(): ?int
    {
        return $this->timeShiftSlidingWindow;
    }

    /**
     * @param int $timeShiftSlidingWindow
     */
    public function setTimeShiftSlidingWindow(int $timeShiftSlidingWindow): void
    {
        $this->timeShiftSlidingWindow = $timeShiftSlidingWindow;
    }

    /**
     * @return ChannelGroup|null
     */
    public function getChannelGroup(): ?ChannelGroup
    {
        return $this->channelGroup;
    }

    /**
     * @param ChannelGroup $channelGroup
     */
    public function setChannelGroup(ChannelGroup $channelGroup): void
    {
        $this->channelGroup = $channelGroup;
    }

    /**
     * @param EpgEvent $event
     * @return $this
     */
    public function addEpgEvent(EpgEvent $event): self
    {
        if (!$this->epgEvents->contains($event)) {
            $this->epgEvents[] = $event;
            $event->setChannel($this);
        }

        return $this;
    }

    /**
     * @Field()
     * @return string
     */
    public function getDcApiId(): string
    {
        return $this->dcApiId;
    }

    /**
     * @param string $dcApiId
     */
    public function setDcApiId(string $dcApiId): void
    {
        $this->dcApiId = $dcApiId;
    }

    /**
     * @Field()
     * @return \DateTimeImmutable|null
     */
    public function getLastUpdate(): ?\DateTimeImmutable
    {
        return $this->lastUpdate;
    }

    /**
     * @param \DateTimeImmutable|null $lastUpdate
     */
    public function setLastUpdate(?\DateTimeImmutable $lastUpdate): void
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @Field()
     * @return \DateTimeImmutable|null
     */
    public function getLastSynchronization(): ?\DateTimeImmutable
    {
        return $this->lastSynchronization;
    }

    /**
     * @param \DateTimeImmutable|null $lastSynchronization
     */
    public function setLastSynchronization(?\DateTimeImmutable $lastSynchronization): void
    {
        $this->lastSynchronization = $lastSynchronization;
    }

    /**
     * @Field()
     * @return string|null
     */
    public function getExternalName(): ?string
    {
        return $this->externalName;
    }

    /**
     * @param string|null $externalName
     */
    public function setExternalName(?string $externalName): void
    {
        $this->externalName = $externalName;
    }
}
