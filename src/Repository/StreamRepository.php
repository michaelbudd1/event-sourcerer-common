<?php

namespace PearTreeWeb\EventSourcerer\Common\Repository;

use PearTreeWeb\EventSourcerer\Common\Model\Checkpoint;
use PearTreeWeb\EventSourcerer\Common\Model\Stream;
use PearTreeWeb\EventSourcerer\Common\Model\StreamId;

interface StreamRepository
{
    public function get(StreamId $id, Checkpoint $checkpoint): iterable;

    public function save(Stream $aggregate): void;
}
