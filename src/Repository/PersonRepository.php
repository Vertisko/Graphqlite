<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    /**
     * PersonRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    /**
     * @param string $externalId
     * @return Person|null
     */
    public function findByExternalId(string $externalId): ?Person
    {
        return $this->findOneBy(['externalId' => $externalId]);
    }

    /**
     * @param Person $person
     * @return Person
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Person $person): Person
    {
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();

        return $person;
    }
}
