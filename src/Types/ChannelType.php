<?php declare(strict_types=1);

namespace App\Types;

use App\Entity\Channel;
use App\Service\EpgEventService;
use TheCodingMachine\GraphQLite\Annotations\ExtendType;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\UseInputType;

/**
* @ExtendType(class=Channel::class)
*/
class ChannelType
{
    private EpgEventService $epgEventService;

    /**
     * ChannelType constructor.
     *
     * @param EpgEventService $epgEventService
     */
    public function __construct(EpgEventService $epgEventService)
    {
        $this->epgEventService = $epgEventService;
    }

    /**
     * @Field()
     * @param Channel $channel
     * @param string $date
     * @param string $timezone
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     * @UseInputType(for="$date", inputType="Date!")
     * @UseInputType(for="$timezone", inputType="Timezone!")
     */
    public function getEpgEvents(Channel $channel, string $date, string $timezone, ?int $limit = null, ?int $offset = null): array
    {
        /** @var \DateTimeImmutable $startDate */
        $startDate = \DateTimeImmutable::createFromFormat(\DateTimeImmutable::ATOM, $date . 'T00:00:00'. $timezone);
        /** @var \DateTimeImmutable $endDate */
        $endDate = \DateTimeImmutable::createFromFormat(\DateTimeImmutable::ATOM, $date . 'T23:59:59'. $timezone);

        return $this->epgEventService->getChannelEpgEvents($startDate, $endDate, $channel, $limit, $offset);
    }
}
