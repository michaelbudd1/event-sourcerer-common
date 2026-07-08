<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Repository;

use PearTreeWeb\EventSourcerer\Common\Aggregate\Aggregate;
use PearTreeWeb\EventSourcerer\Common\Factory\ReinstantiateAggregate;
use PearTreeWeb\EventSourcerer\Common\Model\AggregateId;
use PearTreeWeb\EventSourcerer\Common\Model\Checkpoint;
use PearTreeWeb\EventSourcerer\Common\Model\IsAggregate;
use PearTreeWeb\EventSourcerer\Common\Model\Stream;
use PearTreeWeb\EventSourcerer\Common\Service\ProvideEventClassPath;

abstract readonly class EventSourcererAggregateRepository implements AggregateRepository
{
    public function __construct(
        private StreamRepository $streamRepository,
        private ReinstantiateAggregate $reinstantiateAggregate,
        private ProvideEventClassPath $provideEventClassPath,
    ) {}

    public function get(AggregateId $aggregateId): IsAggregate
    {
        $aggregateClass = static::aggregateClass();

        return $this->reinstantiateAggregate->fromEvents(
            $this->provideEventClassPath,
            $aggregateClass,
            $this->streamRepository->get($aggregateClass::streamId($aggregateId), Checkpoint::zero())
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

    /**
     * @return class-string<Aggregate>
     */
    abstract protected static function aggregateClass(): string;
}
