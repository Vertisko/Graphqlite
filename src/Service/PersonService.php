<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class PersonService
{
    private PersonRepository $personRepository;

    /**
     * PersonService constructor.
     *
     * @param PersonRepository $personRepository
     */
    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * @param string $externalId
     * @param string $firstName
     * @param string $lastName
     * @return Person
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function loadPerson(string $externalId, string $firstName, string $lastName): Person
    {
        $person = $this->personRepository->findByExternalId($externalId);

        if (!\is_null($person)) {
            return $person;
        }

        // FIXME update data in future
        return $this->createPerson($externalId, $firstName, $lastName);
    }

    /**
     * @param string $externalId
     * @param string $firstName
     * @param string $lastName
     * @return Person
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createPerson(string $externalId, string $firstName, string $lastName): Person
    {
        $person = Person::create($externalId, $firstName, $lastName);

        return $this->personRepository->save($person);
    }
}
