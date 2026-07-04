<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Repository;

use PearTreeWeb\EventSourcerer\Common\Factory\ReinstantiateAggregate;
use PearTreeWeb\EventSourcerer\Common\Model\Checkpoint;
use PearTreeWeb\EventSourcerer\Common\Model\IsAggregate;
use PearTreeWeb\EventSourcerer\Common\Model\Stream;
use PearTreeWeb\EventSourcerer\Common\Model\StreamId;
use PearTreeWeb\EventSourcerer\Common\Service\ProvideEventClassPath;

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
