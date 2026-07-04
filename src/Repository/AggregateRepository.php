<?php

namespace EventSourcerer\EventSourcererCqrs\Repository;

use EventSourcerer\EventSourcererCqrs\Aggregate\Model\IsAggregate;
use PearTreeWebLtd\EventSourcererMessageUtilities\Model\StreamId;

interface AggregateRepository
{
    public function get(StreamId $streamId): IsAggregate;

    public function save(IsAggregate $aggregate): void;
}
