<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

interface CanBeRepresentedAsArray
{
    public function toArray(): array;
}
