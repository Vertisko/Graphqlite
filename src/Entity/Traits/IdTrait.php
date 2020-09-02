<?php declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use TheCodingMachine\GraphQLite\Annotations\Field;

trait IdTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private string $id;

    /**
     * @Field(name="id", outputType="ID")
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string|null $guid
     */
    public function setId(?string $guid = null): void
    {
        $guid ??= (string) Uuid::uuid4();
        $this->id = $guid;
    }
}
