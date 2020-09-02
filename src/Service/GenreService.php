<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class GenreService
{
    private GenreRepository $genreRepository;

    /**
     * GenreService constructor.
     *
     * @param GenreRepository $genreRepository
     */
    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    /**
     * @param string $externalId
     * @param string $name
     * @param string $imageUrl
     * @return Genre
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function loadGenre(string $externalId, string $name, string $imageUrl): Genre
    {
        $genre = $this->genreRepository->findByExternalId($externalId);

        if (!\is_null($genre)) {
            return $genre;
        }

        //FIXME update data in future
        return $this->createGenre($externalId, $name, $imageUrl);
    }

    /**
     * @param string $externalId
     * @param string $name
     * @param string $imageUrl
     * @return Genre
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createGenre(string $externalId, string $name, string $imageUrl): Genre
    {
        $genre = Genre::create($externalId, $name, $imageUrl);

        return $this->genreRepository->save($genre);
    }
}
