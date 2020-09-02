<?php declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use TheCodingMachine\GraphQLite\Annotations\Field;

trait ExternalEntityTrait
{
    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=true)
     */
    private ?string $externalId;

    /**
     * @Field()
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * @param string|null $externalId
     * @return void
     */
    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
    }
}
