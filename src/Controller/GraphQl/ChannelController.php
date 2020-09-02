<?php declare(strict_types=1);

namespace App\Controller\GraphQl;

use App\Entity\Channel;
use App\Service\ChannelService;
use TheCodingMachine\GraphQLite\Annotations\Query;

class ChannelController
{
    private ChannelService $channelService;

    /**
     * ChannelController constructor.
     *
     * @param ChannelService $channelService
     */
    public function __construct(ChannelService $channelService)
    {
        $this->channelService = $channelService;
    }

    /**
     * @Query
     * @param int|null $limit
     * @param int|null $offset
     * @return Channel[]
     */
    public function channels(?int $limit, ?int $offset): array
    {
        return $this->channelService->getChannels($limit, $offset);
    }
}
