<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Channel;
use App\Entity\ChannelGroup;
use App\Exceptions\NonExistingEntityException;
use App\Repository\ChannelGroupRepository;
use App\Repository\ChannelRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ObjectManager;
use Exception;

class ChannelFixtures extends Fixture implements DependentFixtureInterface
{
    private const GROUP_KEY = 'channelGroup';
    private const NAME_KEY = 'name';
    private const DESCRIPTION_KEY = 'description';
    private const LOGO_URL_KEY = 'logoUrl';
    private const PARENTAL_RATING = 'parentalRating';
    private const TIME_SHIFT_SLIDING_WINDOW_KEY = 'timeShiftSlidingWindow';
    private const ACTIVATED_KEY = 'activated';
    private const DC_API_ID_KEY = 'dcApiId';
    private const EXTERNAL_ID_KEY = 'externalId';

    /**
     * @param ObjectManager $objectManager
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function load(ObjectManager $objectManager): void
    {
        /** @var ChannelGroupRepository $channelGroupRepository */
        $channelGroupRepository = $objectManager->getRepository(ChannelGroup::class);

        /** @var ChannelRepository $channelRepository */
        $channelRepository = $objectManager->getRepository(Channel::class);

        $channels = [
            [
                self::GROUP_KEY => 'sports',
                self::NAME_KEY => 'CT sport',
                self::DC_API_ID_KEY => '5',
                self::DESCRIPTION_KEY => 'Free channel',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 1,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168, // 7 days
                self::ACTIVATED_KEY => true,
                self::EXTERNAL_ID_KEY => '1',
            ],
            [
                self::GROUP_KEY => 'sports',
                self::NAME_KEY => 'Arena Sport 1',
                self::DC_API_ID_KEY => '340',
                self::DESCRIPTION_KEY => '',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 1,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168, // 7 days
                self::ACTIVATED_KEY => true,
                self::EXTERNAL_ID_KEY => '2',
            ],
            [
                self::GROUP_KEY => 'sports',
                self::NAME_KEY => 'Arena Sport 2',
                self::DC_API_ID_KEY => '346',
                self::DESCRIPTION_KEY => '',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 1,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168, // 7 days
                self::ACTIVATED_KEY => true,
                self::EXTERNAL_ID_KEY => '3',
            ],
            [
                self::GROUP_KEY => 'esports',
                self::NAME_KEY => 'GINX',
                self::DC_API_ID_KEY => '800',
                self::DESCRIPTION_KEY => '',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 0,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168,
                self::ACTIVATED_KEY => true,
                self::EXTERNAL_ID_KEY => '4',
            ],
            [
                self::GROUP_KEY => 'sports',
                self::NAME_KEY => 'Golf Channel',
                self::DC_API_ID_KEY => '512',
                self::DESCRIPTION_KEY => '',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 2,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168,
                self::ACTIVATED_KEY => true,
                self::EXTERNAL_ID_KEY => '5',
            ],
            [
                self::GROUP_KEY => 'sports',
                self::NAME_KEY => 'Sport 5',
                self::DC_API_ID_KEY => '511',
                self::DESCRIPTION_KEY => '',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 2,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168,
                self::ACTIVATED_KEY => true,
                self::EXTERNAL_ID_KEY => '6',
            ],
            [
                self::GROUP_KEY => 'sports',
                self::NAME_KEY => 'Nova Sport 1',
                self::DC_API_ID_KEY => '2',
                self::DESCRIPTION_KEY => '',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 2,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168,
                self::ACTIVATED_KEY => false,
                self::EXTERNAL_ID_KEY => '7',
            ],
            [
                self::GROUP_KEY => 'sports',
                self::NAME_KEY => 'Nova Sport 2',
                self::DC_API_ID_KEY => '568',
                self::DESCRIPTION_KEY => '',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 2,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168,
                self::ACTIVATED_KEY => true,
                self::EXTERNAL_ID_KEY => '8',
            ],
            [
                self::GROUP_KEY => 'sports',
                self::NAME_KEY => 'ČT 24',
                self::DC_API_ID_KEY => '',
                self::DESCRIPTION_KEY => '',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 2,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168,
                self::ACTIVATED_KEY => true,
                self::EXTERNAL_ID_KEY => '9',
            ],
            [
                self::GROUP_KEY => 'sports',
                self::NAME_KEY => 'Prima Cool',
                self::DC_API_ID_KEY => '139',
                self::DESCRIPTION_KEY => '',
                self::LOGO_URL_KEY => 'https://i.imgur.com/OkHBBTz.jpg',
                self::PARENTAL_RATING => 2,
                self::TIME_SHIFT_SLIDING_WINDOW_KEY => 168,
                self::ACTIVATED_KEY => true,
                self::EXTERNAL_ID_KEY => '10',
            ],
        ];

        foreach ($channels as $channel) {
            $channelGroup = $channelGroupRepository->findByName($channel[self::GROUP_KEY]);

            if (\is_null($channelGroup)) {
                throw new NonExistingEntityException(ChannelGroup::class, 'name', $channel[self::GROUP_KEY]);
            }

            $channelObject = Channel::create($channelGroup,
                $channel[self::NAME_KEY],
                $channel[self::LOGO_URL_KEY],
                $channel[self::TIME_SHIFT_SLIDING_WINDOW_KEY],
                $channel[self::DC_API_ID_KEY],
                $channel[self::PARENTAL_RATING],
                $channel[self::DESCRIPTION_KEY],
                $channel[self::ACTIVATED_KEY],
            );
            $channelObject->setExternalId($channel[self::EXTERNAL_ID_KEY]);

            $channelRepository->save($channelObject);
        }
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            ChannelGroupFixtures::class,
        ];
    }
}
