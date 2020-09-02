<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Genre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Genre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Genre[]    findAll()
 * @method Genre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreRepository extends ServiceEntityRepository
{
    /**
     * GenreRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    /**
     * @param string $id
     * @return Genre|null
     */
    public function findByExternalId(string $id): ?Genre
    {
        return $this->findOneBy(['externalId' => $id]);
    }

    /**
     * @return Genre
     * @param Genre $genre
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Genre $genre): Genre
    {
        $this->getEntityManager()->persist($genre);
        $this->getEntityManager()->flush();

        return $genre;
    }
}
