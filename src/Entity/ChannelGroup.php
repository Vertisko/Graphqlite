<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\TimestampAbleInterface;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampAbleTrait;
use App\Repository\ChannelGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChannelGroupRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class ChannelGroup implements IdInterface, TimestampAbleInterface
{
    use IdTrait;
    use TimestampAbleTrait;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @param string $name
     * @return ChannelGroup
     */
    public static function create(string $name): self
    {
        $channelGroup = new self();
        $channelGroup->setId();
        $channelGroup->setName($name);

        return $channelGroup;
    }

    /**
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
}
