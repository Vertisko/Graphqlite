<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Channel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Channel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Channel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Channel[]    findAll()
 * @method Channel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelRepository extends ServiceEntityRepository
{
    /**
     * ChannelRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Channel::class);
    }

    /**
     * @param Channel $channel
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Channel $channel): void
    {
        $this->getEntityManager()->persist($channel);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Channel $channel
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Channel $channel): void
    {
        $this->getEntityManager()->remove($channel);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $externalId
     * @return Channel|null
     */
    public function findByExternalId(string $externalId): ?Channel
    {
        return $this->findOneBy([
            'externalId' => $externalId,
        ]);
    }

    /**
     * @param string $dcApiId
     * @return Channel|null
     */
    public function findByDcApiId(string $dcApiId): ?Channel
    {
        return $this->findOneBy([
            'dcApiId' => $dcApiId,
        ]);
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return Channel[]
     */
    public function findChannels(?int $limit, ?int $offset): array
    {
        $qb = $this->createQueryBuilder('c');

        if (!\is_null($limit)) {
            $qb->setMaxResults($limit);
        }

        if (!\is_null($offset)) {
            $qb->setMaxResults($offset);
        }

        return $qb->getQuery()->getResult();
    }
}
