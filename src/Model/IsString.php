<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

interface IsString extends \Stringable
{
    public const string NULL_REPRESENTATION = '';

    public static function fromString(string $value): self;

    public function toString(): string;
}
