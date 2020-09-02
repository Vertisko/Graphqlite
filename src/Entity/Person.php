<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Interfaces\ExternalEntityInterface;
use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\TimestampAbleInterface;
use App\Entity\Traits\ExternalEntityTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampAbleTrait;
use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person implements IdInterface, TimestampAbleInterface, ExternalEntityInterface
{
    use IdTrait;
    use TimestampAbleTrait;
    use ExternalEntityTrait;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $lastName;

    /**
     * @param string $externalId
     * @param string $firstName
     * @param string $lastName
     * @return Person
     */
    public static function create(string $externalId, string $firstName, string $lastName): Person
    {
        $person = new Person();
        $person->setId();
        $person->setExternalId($externalId);
        $person->setFirstName($firstName);
        $person->setLastName($lastName);

        return $person;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
