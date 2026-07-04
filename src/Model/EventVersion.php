<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

final class EventVersion implements IsInteger
{
    public const int DEFAULT = 1;

    use FulfilIsInteger;

    public static function default(): self
    {
        return new self(self::DEFAULT);
    }
}


