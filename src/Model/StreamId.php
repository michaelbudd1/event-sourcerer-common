<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

final readonly class StreamId implements IsString
{
    use FulfilIsString;

    private const string ALL_STREAM = '*';

    public function isAllStream(): bool
    {
        return self::ALL_STREAM === $this->value;
    }

    public static function allStream(): self
    {
        return self::fromString(self::ALL_STREAM);
    }
}
