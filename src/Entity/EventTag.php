<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\TimestampAbleInterface;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampAbleTrait;
use App\Repository\EventTagRepository;
use Doctrine\ORM\Mapping as ORM;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 * @ORM\Entity(repositoryClass=EventTagRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class EventTag implements IdInterface, TimestampAbleInterface
{
    use IdTrait;
    use TimestampAbleTrait;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @param string $name
     * @return EventTag
     */
    public static function create(string $name): EventTag
    {
        $channelGroup = new self();
        $channelGroup->setName($name);

        return $channelGroup;
    }

    /**
     * @Field()
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
