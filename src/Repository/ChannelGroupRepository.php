<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\ChannelGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChannelGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChannelGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChannelGroup[]    findAll()
 * @method ChannelGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelGroupRepository extends ServiceEntityRepository
{
    /**
     * ChannelGroupRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChannelGroup::class);
    }

    /**
     * @param ChannelGroup $channelGroup
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(ChannelGroup $channelGroup): void
    {
        $this->getEntityManager()->persist($channelGroup);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $name
     * @return ChannelGroup|null
     */
    public function findByName(string $name): ?ChannelGroup
    {
        return $this->findOneBy([
            'name' => $name,
        ]);
    }
}
