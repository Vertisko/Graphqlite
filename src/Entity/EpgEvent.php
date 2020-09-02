<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\TimestampAbleInterface;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampAbleTrait;
use App\Repository\EpgEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 * @ORM\Entity(repositoryClass=EpgEventRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class EpgEvent implements IdInterface, TimestampAbleInterface
{
    use IdTrait;
    use TimestampAbleTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Channel::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Channel $channel;

    /**
     * @ORM\Column(type="datetimetz_immutable")
     */
    private \DateTimeImmutable $start;

    /**
     * @ORM\Column(name="`end`", type="datetimetz_immutable")
     */
    private \DateTimeImmutable $end;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="epgEvents")
     */
    private ?Event $event;

    /**
     * @var Collection<int, EventTag>
     * @ORM\ManyToMany(targetEntity=EventTag::class)
     */
    private Collection $eventTags;

    /**
     * EpgEvent constructor.
     */
    public function __construct()
    {
        $this->eventTags = new ArrayCollection();
    }

    /**
     * @param string $name
     * @param Channel $channel
     * @param \DateTimeImmutable $start
     * @param \DateTimeImmutable $end
     * @return EpgEvent
     */
    public static function create(string $name, Channel $channel, \DateTimeImmutable $start, \DateTimeImmutable $end): EpgEvent
    {
        $epgEvent = new self();
        $epgEvent->setId(null);
        $epgEvent->setName($name);
        $epgEvent->setChannel($channel);
        $epgEvent->setStart($start);
        $epgEvent->setEnd($end);

        return $epgEvent;
    }

    /**
     * @Field(name="name", outputType="URL")
     * @return string
     */
    public function getName(): string
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
     * @return Channel
     */
    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     */
    public function setChannel(Channel $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @Field()
     * @return \DateTimeImmutable
     */
    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @param \DateTimeImmutable $start
     */
    public function setStart(\DateTimeImmutable $start): void
    {
        $this->start = $start;
    }

    /**
     * @Field()
     * @return \DateTimeImmutable
     */
    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }

    /**
     * @param \DateTimeImmutable $end
     */
    public function setEnd(\DateTimeImmutable $end): void
    {
        $this->end = $end;
    }

    /**
     * @Field()
     * @return Event|null
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * @param Event|null $event
     */
    public function setEvent(?Event $event): void
    {
        $this->event = $event;
    }

    /**
     * @Field()
     * @return Collection<int, EventTag>|EventTag[]
     */
    public function getEventTags(): Collection
    {
        return $this->eventTags;
    }

    /**
     * @param EventTag $eventTag
     */
    public function addEventTag(EventTag $eventTag): void
    {
        if ($this->eventTags->contains($eventTag)) {
            return;
        }

        $this->eventTags[] = $eventTag;
    }
}
