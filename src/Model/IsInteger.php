<?php

namespace PearTreeWeb\EventSourcerer\Common\Model;

interface IsInteger
{
    public static function fromInt(int $value): self;

    public function toInt(): int;
}
