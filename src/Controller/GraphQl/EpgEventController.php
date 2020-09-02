<?php declare(strict_types=1);

namespace App\Controller\GraphQl;

use App\Entity\EpgEvent;
use App\Service\ChannelService;
use App\Service\EpgEventService;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\UseInputType;
use TheCodingMachine\GraphQLite\Types\ID;

class EpgEventController
{
    private EpgEventService $epgEventService;

    /**
     * @var ChannelService
     */
    private ChannelService $channelService;

    /**
     * ChannelController constructor.
     *
     * @param EpgEventService $epgEventService
     * @param ChannelService $channelService
     */
    public function __construct(EpgEventService $epgEventService, ChannelService $channelService)
    {
        $this->epgEventService = $epgEventService;
        $this->channelService = $channelService;
    }

    /**
     * @Query
     * @UseInputType(for="$date", inputType="Date!")
     * @UseInputType(for="$timezone", inputType="Timezone!")
     * @param string $date
     * @param string $timezone
     * @param ID $channelId
     * @param int|null $limit
     * @param int|null $offset
     * @return EpgEvent[]
     * @throws \Exception
     */
    public function epgEvents(string $date, string $timezone, ID $channelId, ?int $limit = null, ?int $offset = null): array
    {
        /** @var \DateTimeImmutable $startDate */
        $startDate = \DateTimeImmutable::createFromFormat(\DateTimeImmutable::ATOM, $date . 'T00:00:00'. $timezone);
        /** @var \DateTimeImmutable $endDate */
        $endDate = \DateTimeImmutable::createFromFormat(\DateTimeImmutable::ATOM, $date . 'T23:59:59'. $timezone);

        $channel = $this->channelService->getChannelById((string) $channelId->val());

        return $this->epgEventService->getChannelEpgEvents($startDate, $endDate, $channel, $limit, $offset);
    }
}
