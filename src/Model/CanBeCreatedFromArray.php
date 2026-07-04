<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

interface CanBeCreatedFromArray
{
    public static function fromArray(array $array);
}
