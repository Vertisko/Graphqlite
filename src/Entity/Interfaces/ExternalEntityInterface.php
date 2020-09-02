<?php declare(strict_types=1);

namespace App\Entity\Interfaces;

interface ExternalEntityInterface
{
    /**
     * @return string|null
     */
    public function getExternalId(): ?string;

    /**
     * @param string $externalId
     */
    public function setExternalId(string $externalId): void;
}
