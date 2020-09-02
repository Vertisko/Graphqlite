<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\ChannelGroup;
use App\Repository\ChannelGroupRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ObjectManager;
use Exception;

class ChannelGroupFixtures extends Fixture
{
    /**
     * @param ObjectManager $objectManager
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function load(ObjectManager $objectManager): void
    {
        /** @var ChannelGroupRepository $channelGroupRepository */
        $channelGroupRepository = $objectManager->getRepository(ChannelGroup::class);

        $groups = [
            'sports',
            'esports',
        ];

        foreach ($groups as $groupName) {
            $channelGroup = ChannelGroup::create($groupName);
            $channelGroupRepository->save($channelGroup);
        }

        $objectManager->flush();
    }
}
