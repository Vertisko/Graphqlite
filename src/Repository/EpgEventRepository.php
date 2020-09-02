<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Channel;
use App\Entity\EpgEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EpgEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method EpgEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method EpgEvent[]    findAll()
 * @method EpgEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EpgEventRepository extends ServiceEntityRepository
{
    /**
     * EpgEventRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EpgEvent::class);
    }

    /**
     * @param \DateTimeImmutable $dateFrom
     * @param Channel|null $channel
     * @return int
     */
    public function deleteEpgEvents(\DateTimeImmutable $dateFrom, ?Channel $channel = null): int
    {
        $qb = $this
            ->createQueryBuilder('e')
            ->delete()
            ->where('e.start >= :dateFrom')
            ->setParameter('dateFrom', $dateFrom);

        if (!\is_null($channel)) {
            $qb->andWhere('e.channel = :channel')
                ->setParameter('channel', $channel);
        }

        return $qb->getQuery()
            ->getResult();
    }

    /**
     * @return EpgEvent
     * @param EpgEvent $epgEvent
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(EpgEvent $epgEvent): EpgEvent
    {
        $this->getEntityManager()->persist($epgEvent);
        $this->getEntityManager()->flush();

        return $epgEvent;
    }

    /**
     * @param \DateTimeImmutable $startDate
     * @param \DateTimeImmutable $endDate
     * @param Channel|null $channel
     * @param int|null $limit
     * @param int|null $offset
     * @return EpgEvent[]
     */
    public function findEpgEvents(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate, ?Channel $channel = null,  ?int $limit = null, ?int $offset = null): array
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.start = :startDate')
            ->andWhere('e.end = :endDate')
            ->setParameters([
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);

        if (!\is_null($channel)) {
            $qb->andWhere('e.channel = :channel')
                ->setParameter('channel', $channel);
        }

        if (!\is_null($limit)) {
            $qb->setMaxResults($limit);
        }

        if (\is_null($offset)) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }
}
