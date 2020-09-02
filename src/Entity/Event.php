<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\ExternalEntityInterface;
use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\TimestampAbleInterface;
use App\Entity\Traits\ExternalEntityTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampAbleTrait;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event implements IdInterface, TimestampAbleInterface, ExternalEntityInterface
{
    use IdTrait;
    use TimestampAbleTrait;
    use ExternalEntityTrait;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $originalTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $posterUrl;

    /**
     * @var Collection<int, Genre>
     * @ORM\ManyToMany(targetEntity=Genre::class)
     */
    private Collection $genres;

    /**
     * @var Collection<int, Person>
     * @ORM\ManyToMany(targetEntity=Person::class)
     * @ORM\JoinTable(name="event_directors")
     */
    private Collection $directors;

    /**
     * @var Collection<int, Person>
     * @ORM\ManyToMany(targetEntity=Person::class)
     * @ORM\JoinTable(name="event_actors")
     */
    private Collection $actors;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $year;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $number;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $synopsis;

    /**
     * @var Collection <int,EpgEvent>
     * @ORM\OneToMany(targetEntity=EpgEvent::class, mappedBy="event")
     */
    private Collection $epgEvents;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->directors = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->epgEvents = new ArrayCollection();
    }

    /**
     * @param string $title
     * @param string $synopsis
     * @param int $year
     * @param string|null $originalTitle
     * @param string|null $posterUrl
     * @param int|null $number
     * @return Event
     */
    public static function create(string $title,
                                  string $synopsis,
                                  int $year,
                                  ?string $originalTitle = null,
                                  ?string $posterUrl = null,
                                  ?int $number = null): Event
    {
        $event = new self();
        $event->setTitle($title);
        $event->setSynopsis($synopsis);
        $event->setYear($year);
        $event->setOriginalTitle($originalTitle);
        $event->setPosterUrl($posterUrl);
        $event->setNumber($number);

        return $event;
    }

    /**
     * @Field()
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @Field()
     * @return string|null
     */
    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    /**
     * @param string|null $originalTitle
     */
    public function setOriginalTitle(?string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /**
     * @Field()
     * @return string|null
     */
    public function getPosterUrl(): ?string
    {
        return $this->posterUrl;
    }

    /**
     * @param string|null $posterUrl
     */
    public function setPosterUrl(?string $posterUrl): void
    {
        $this->posterUrl = $posterUrl;
    }

    /**
     * @Field()
     * @return Collection<int, Genre>|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    /**
     * @param Genre $genre
     */
    public function addGenre(Genre $genre): void
    {
        if ($this->genres->contains($genre)) {
            return;
        }

        $this->genres[] = $genre;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getDirectors(): Collection
    {
        return $this->directors;
    }

    /**
     * @param Person $director
     */
    public function addDirector(Person $director): void
    {
        if ($this->directors->contains($director)) {
            return;
        }

        $this->directors[] = $director;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    /**
     * @param Person $actor
     */
    public function addActor(Person $actor): void
    {
        if ($this->actors->contains($actor)) {
            return;
        }

        $this->actors[] = $actor;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return string|null
     */
    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    /**
     * @param string $synopsis
     */
    public function setSynopsis(string $synopsis): void
    {
        $this->synopsis = $synopsis;
    }

    /**
     * @return Collection<int, EpgEvent>
     */
    public function getEpgEvents(): Collection
    {
        return $this->epgEvents;
    }

    /**
     * @param EpgEvent $epgEvent
     * @return void
     */
    public function addEpgEvent(EpgEvent $epgEvent): void
    {
        if ($this->epgEvents->contains($epgEvent)) {
            return;
        }

        $this->epgEvents[] = $epgEvent;
        $epgEvent->setEvent($this);
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     */
    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }
}
