<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Channel;
use App\Entity\EpgEvent;
use App\Repository\EpgEventRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class EpgEventService
{
    private EpgEventRepository $epgEventRepository;

    /**
     * EpgEventService constructor.
     *
     * @param EpgEventRepository $epgEventRepository
     */
    public function __construct(EpgEventRepository $epgEventRepository)
    {
        $this->epgEventRepository = $epgEventRepository;
    }

    /**
     * @param EpgEvent $epgEvent
     * @return EpgEvent
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(EpgEvent $epgEvent): EpgEvent
    {
        $this->epgEventRepository->save($epgEvent);

        return $epgEvent;
    }

    /**
     * @param \DateTimeImmutable|null $dateFrom
     * @param Channel|null $channel
     * @return int
     */
    public function deleteEpgEvents(?\DateTimeImmutable $dateFrom = null, ?Channel $channel = null): int
    {
        $dateFrom ??= (new \DateTimeImmutable())->setTime(0,0,0);

        return $this->epgEventRepository->deleteEpgEvents($dateFrom, $channel);
    }

    /**
     * @param string $name
     * @param Channel $channel
     * @param \DateTimeImmutable $start
     * @param \DateTimeImmutable $end
     * @return EpgEvent
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createEpgEvent(string $name, Channel $channel, \DateTimeImmutable $start, \DateTimeImmutable $end): EpgEvent
    {
        $epgEvent = EpgEvent::create($name, $channel, $start, $end);

        return $this->epgEventRepository->save($epgEvent);
    }

    /**
     * @param Channel $channel
     * @param \DateTimeImmutable $startDate
     * @param \DateTimeImmutable $endDate
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getChannelEpgEvents(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate, Channel $channel, ?int $limit = null, ?int $offset = null): array
    {
        return $this->epgEventRepository->findEpgEvents($startDate, $endDate, $channel, $limit, $offset);
    }
}
