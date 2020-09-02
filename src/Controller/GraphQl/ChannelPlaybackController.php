<?php declare(strict_types=1);

namespace App\Controller\GraphQl;

use App\Entity\DTO\ChannelPlayback;
use App\Service\ChannelService;
use App\Types\Input\ChannelPlaybackInput;
use App\Utils\LinkResponseGenerator;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Types\ID;

class ChannelPlaybackController
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
     * @param ID $channelId
     * @param ID $profileId
     * @param ChannelPlaybackInput $channelPlaybackInput
     * @return ChannelPlayback
     * @throws \Exception
     */
    public function channelPlayback(ID $channelId,
                                    ID $profileId,
                                    ChannelPlaybackInput $channelPlaybackInput
    ): ChannelPlayback
    {
        $videoFormats = $channelPlaybackInput->getVideoFormats();
        $audioFormats = $channelPlaybackInput->getAudioFormats();
        $drm = $channelPlaybackInput->getDrm();
        $streamFormat = $channelPlaybackInput->getStreamFormat();
        $abrNotSupported = $channelPlaybackInput->isAbrNotSupported();

        // FIXME send to core
        return LinkResponseGenerator::generate(
            (string) $channelId->val(),
            (string) $profileId->val(),
            $streamFormat->getValue(),
            $videoFormats,
            $audioFormats,
            $abrNotSupported,
            $drm->getValue(),
        );
    }
}
