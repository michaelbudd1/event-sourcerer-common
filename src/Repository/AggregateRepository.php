<?php

namespace PearTreeWeb\EventSourcerer\Common\Repository;

use PearTreeWeb\EventSourcerer\Common\Model\IsAggregate;
use PearTreeWeb\EventSourcerer\Common\Model\StreamId;

interface AggregateRepository
{
    public function get(StreamId $streamId): IsAggregate;

    public function save(IsAggregate $aggregate): void;
}
