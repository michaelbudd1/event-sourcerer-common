<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

trait FulfilIsString
{
    private function __construct(private readonly string $value) {}

    public static function create(?string $value): self
    {
        self::validate($value);

        return $value
            ? new self($value)
            : new self(IsString::NULL_REPRESENTATION);
    }

    protected static function validate(?string $value): void
    {
    }

    public function sameAs(self $other): bool
    {
        return $other->toString() === $this->value;
    }

    public static function fromString(string $value): self
    {
        return new static($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
