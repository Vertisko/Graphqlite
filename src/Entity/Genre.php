<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\ExternalEntityInterface;
use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\TimestampAbleInterface;
use App\Entity\Traits\ExternalEntityTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampAbleTrait;
use App\Repository\GenreRepository;
use Doctrine\ORM\Mapping as ORM;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type
 * @ORM\Entity(repositoryClass=GenreRepository::class)
 */
class Genre implements IdInterface, TimestampAbleInterface, ExternalEntityInterface
{
    use IdTrait;
    use TimestampAbleTrait;
    use ExternalEntityTrait;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $imageUrl;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @param string $externalId
     * @param string $name
     * @param string $imageUrl
     * @return Genre
     */
    public static function create(string $externalId, string $name, string $imageUrl): Genre
    {
        $genre = new Genre();
        $genre->setId();
        $genre->setExternalId($externalId);
        $genre->setName($name);
        $genre->setImageUrl($imageUrl);

        return $genre;
    }

    /**
     * @Field()
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
