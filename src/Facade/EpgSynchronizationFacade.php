<?php declare(strict_types=1);

namespace App\Facade;

use App\Entity\Channel;
use App\Entity\EpgEvent;
use App\Entity\Event;
use App\Service\ChannelService;
use App\Service\EpgEventService;
use App\Service\GenreService;
use App\Service\PersonService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EpgSynchronizationFacade
{
    private const DAYS_TO_SYNC = 7;

    private ChannelService $channelService;

    private HttpClientInterface $httpClient;

    private EpgEventService $epgEventService;

    private PersonService $personService;

    private GenreService $genreService;

    private string $timezone;

    /**
     * EpgSynchronizationFacade constructor.
     *
     * @param ChannelService $channelService
     * @param EpgEventService $epgEventService
     * @param PersonService $personService
     * @param GenreService $genreService
     * @param HttpClientInterface $lstvDbApi
     * @param string $timezone
     */
    public function __construct(ChannelService $channelService,
                                EpgEventService $epgEventService,
                                PersonService $personService,
                                GenreService $genreService,
                                HttpClientInterface $lstvDbApi,
                                string $timezone)
    {
        $this->channelService = $channelService;
        $this->httpClient = $lstvDbApi;
        $this->epgEventService = $epgEventService;
        $this->personService = $personService;
        $this->genreService = $genreService;
        $this->timezone = $timezone;
    }

    /**
     * @return int
     * @throws ClientExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function synchronizeEpg(): int
    {
        return $this->synchronizeChannels();
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function sendRequest(string $method, string $url, array $options = []): array
    {
        try {
            $response = $this->httpClient->request($method, $url, $options);
        } catch (\Throwable $throwable) {
            return [];
        }

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            return [];
        }

        return \json_decode($response->getContent(), true);
    }

    /**
     * @return int
     * @throws ClientExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function synchronizeChannels(): int
    {
        $data = $this->sendRequest('GET', '/channels');

        $channelsCounter = 0;
        foreach ($data['channels'] as $channelData) {

            $channel = $this->channelService->getChannelByDcApiId($channelData['broadcast_channel_id']);
            if (\is_null($channel)) {
                continue;
            }
            $channel->setExternalName($channelData['name']);
            $channel->setExternalId($channelData['channel_id']);
            $this->channelService->save($channel);

            $this->synchronizeEpgForChannel($channel);

            ++$channelsCounter;
        }

        return $channelsCounter;
    }

    /**
     * @param Channel $channel
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function synchronizeEpgForChannel(Channel $channel): void
    {
        $dateFromSync = (new \DateTimeImmutable())->setTime(0,0,0);

        $options = [

            'query' => [
                'channel' => $channel->getExternalId(),
            ],
        ];

        $formattedDateFromSync = $dateFromSync->format('Y-m-d');
        $formattedDateToSync = $dateFromSync->modify('+' . self::DAYS_TO_SYNC . 'days')->format('Y-m-d');
        $options['query']['from'] = $formattedDateFromSync;
        $options['query']['to'] = $formattedDateToSync;

        $this->epgEventService->deleteEpgEvents($dateFromSync, $channel);
        $response = $this->sendRequest('GET', '/guide', $options);

        // FIXME check response

        foreach ($response['slots'] as $slots) {
            foreach ($slots as $slot) {
                $epgEvent = $this->createEpgEventFromSlot($slot, $channel);
                if (!\is_null($slot['subject_id'])) {
                    $event = $this->synchronizeEvent($slot['subject_id']);
                    $epgEvent->setEvent($event);
                }

                $this->epgEventService->save($epgEvent);
            }
        }
    }

    /**
     * @param string $subjectId
     * @return Event
     * @throws ClientExceptionInterface
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function synchronizeEvent(string $subjectId): Event
    {
        $eventData = $this->sendRequest('GET', "/guide/$subjectId");
        $number = null;

        // FIXME add logic for connecting season with title (creating season if it does not exist)
        if (isset($eventData['number'])) {
            $number = $eventData['number'];
        }

        $event = Event::create(
            $eventData['name'],
            $eventData['description'],
            $eventData['year'],
            $eventData['original_name'],
            $eventData['poster_url'],
            $number,
        );

        $this->processGenres($eventData['genres'], $event);
        $credits = $eventData['credits'];
        $this->processCredits($credits, $event);

        return $event;
    }

    /**
     * @param array<array<string,string>> $genres
     * @param Event $event
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function processGenres(array $genres, Event $event): void
    {
        // FIXME high possibility of change, now expects whole objects but in LSTV-DB api design only IDS are sent

        foreach ($genres as $genre) {
            $genre = $this->genreService->loadGenre($genre['id'], $genre['full_name'], $genre['image_url']);

            $event->addGenre($genre);
        }
    }

    /**
     * @param array $credits
     * @param Event $event
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function processCredits(array $credits, Event $event): void
    {
        $splitter = \count($credits['directors']) - 1;

        $crew = \array_merge($credits['directors'], $credits['actors']);

        foreach ($crew as $key => $member) {
            $person = $this->personService->loadPerson($member['id'], $member['first_name'], $member['last_name']);

            if ($key < $splitter) {
                $event->addDirector($person);
                continue;
            }

            $event->addActor($person);
        }
    }

    /**
     * @return EpgEvent
     * @param array $slot
     * @param Channel $channel
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function createEpgEventFromSlot(array $slot, Channel $channel): EpgEvent
    {
        $timezone = new \DateTimeZone($this->timezone);
        $start = new \DateTimeImmutable($slot['from'], $timezone);
        $end = new \DateTimeImmutable($slot['to'], $timezone);
        $name = $slot['name'] ?? 'NO NAME';

        return $this->epgEventService->createEpgEvent($name, $channel, $start, $end);
    }
}
