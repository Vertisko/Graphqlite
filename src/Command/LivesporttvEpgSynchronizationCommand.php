<?php declare(strict_types=1);

namespace App\Command;

use App\Facade\EpgSynchronizationFacade;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class LivesporttvEpgSynchronizationCommand extends Command
{
    /** @var string $defaultName */
    protected static $defaultName = 'livesporttv:epg:sync';

    private EpgSynchronizationFacade $epgSynchronizationFacade;

    /**
     * LivesporttvEpgSynchronizationCommand constructor.
     *
     * @param EpgSynchronizationFacade $epgSynchronizationFacade
     * @param string|null $name
     */
    public function __construct(EpgSynchronizationFacade $epgSynchronizationFacade, ?string $name = null)
    {
        $this->epgSynchronizationFacade = $epgSynchronizationFacade;

        parent::__construct($name);
    }

    /**
     * Command configuration
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Synchronize EPG data from LSTV DB API.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $updated = $this->epgSynchronizationFacade->synchronizeEpg();

        $io = new SymfonyStyle($input, $output);
        $io->success('EPG successfully synced.');
        $io->success('Channels updated: '.$updated);

        return 0;
    }
}
