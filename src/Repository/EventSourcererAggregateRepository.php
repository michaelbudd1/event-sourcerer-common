<?php

declare(strict_types=1);

namespace EventSourcerer\EventSourcererCqrs\Repository;

use EventSourcerer\EventSourcererCqrs\Aggregate\Model\IsAggregate;
use EventSourcerer\EventSourcererCqrs\Factory\ReinstantiateAggregate;
use PearTreeWebLtd\EventSourcererMessageUtilities\Model\Checkpoint;
use PearTreeWebLtd\EventSourcererMessageUtilities\Model\Stream;
use PearTreeWebLtd\EventSourcererMessageUtilities\Model\StreamId;
use PearTreeWebLtd\EventSourcererMessageUtilities\Repository\StreamRepository;
use PearTreeWebLtd\EventSourcererMessageUtilities\Service\ProvideEventClassPath;

abstract readonly class EventSourcererAggregateRepository implements AggregateRepository
{
    public function __construct(
        private StreamRepository $streamRepository,
        private ReinstantiateAggregate $reinstantiateAggregate,
        private ProvideEventClassPath $provideEventClassPath,
    ) {}

    public function get(StreamId $streamId): IsAggregate
    {
        return $this->reinstantiateAggregate->fromEvents(
            $this->provideEventClassPath,
            static::class,
            $this->streamRepository->get($streamId, Checkpoint::zero())
        );
    }

    public function save(IsAggregate $aggregate): void
    {
        $aggregate = $this->reinstantiateAggregate->withNewEvents(
            $this->provideEventClassPath,
            $aggregate,
        );

        $this->streamRepository->save(
            new Stream(
                $aggregate::streamId($aggregate->id()),
                $aggregate::streamName(),
                $aggregate->newEvents(),
                $aggregate->getCurrentVersion(),
            )
        );

        $aggregate->clearNewEvents();
    }
}
