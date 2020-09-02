<?php declare(strict_types=1);

namespace App\Entity\Interfaces;

interface TimestampAbleInterface
{
    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable;

    /**
     * @param \DateTimeImmutable $createdAt
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?\DateTimeImmutable;

    /**
     * @param \DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void;

    /**
     * ORM prePersist callback.
     *
     * @throws \Exception
     */
    public function setCreatedAtValue(): void;

    /**
     * ORM preUpdate callback.
     *
     * @throws \Exception
     */
    public function setUpdatedAtValue(): void;
}
