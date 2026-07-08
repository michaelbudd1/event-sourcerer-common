<?php

namespace PearTreeWeb\EventSourcerer\Common\Repository;

use PearTreeWeb\EventSourcerer\Common\Model\AggregateId;
use PearTreeWeb\EventSourcerer\Common\Model\IsAggregate;

interface AggregateRepository
{
    public function get(AggregateId $aggregateId): IsAggregate;

    public function save(IsAggregate $aggregate): void;
}
