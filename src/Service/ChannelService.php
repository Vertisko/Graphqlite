<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Channel;
use App\Exceptions\NonExistingEntityException;
use App\Repository\ChannelRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ChannelService
{
    private ChannelRepository $channelRepository;

    /**
     * ChannelService constructor.
     *
     * @param ChannelRepository $channelRepository
     */
    public function __construct(ChannelRepository $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    /**
     * @param string $id
     * @return Channel
     * @throws NonExistingEntityException
     */
    public function getChannelById(string $id): Channel
    {
        $channel = $this->channelRepository->find($id);

        if (!$channel) {
            throw new NonExistingEntityException(Channel::class, 'id', (string) $id);
        }

        return $channel;
    }

    /**
     * @param string $externalId
     * @return Channel
     * @throws NonExistingEntityException
     */
    public function getChannelByExternalId(string $externalId): Channel
    {
        $channel = $this->channelRepository->findByExternalId($externalId);

        if (!$channel) {
            throw new NonExistingEntityException(Channel::class, 'external_id', $externalId);
        }

        return $channel;
    }

    /**
     * @param string $dcApiId
     * @return Channel|null
     */
    public function getChannelByDcApiId(string $dcApiId): ?Channel
    {
        return $this->channelRepository->findByDcApiId($dcApiId);
    }

    /**
     * @param Channel $channel
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Channel $channel): void
    {
        $this->channelRepository->save($channel);
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return Channel[]
     */
    public function getChannels(?int $limit = null, ?int $offset = null): array
    {
        return $this->channelRepository->findChannels($limit, $offset);
    }
}
