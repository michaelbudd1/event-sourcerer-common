<?php

namespace PearTreeWeb\EventSourcerer\Common\Model;

trait FulfilIsInteger
{
    private function __construct(readonly int $value) {}

    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    public static function fromString(string $value): self
    {
        return new self((int) $value);
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public static function one(): self
    {
        return new self(1);
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function isGreaterThan(self $other): bool
    {
        return $this->value > $other->value;
    }

    public function isSameAs(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function increment(): self
    {
        return new self($this->value + 1);
    }

    public function add(int|self $amount): self
    {
        if ($amount instanceof self) {
            return new self($this->value + $amount->value);
        }

        return new self($this->value + $amount);
    }

    public function subtract(int|self $amount): self
    {
        if ($amount instanceof self) {
            return new self($this->value - $amount->value);
        }

        return new self($this->value - $amount);
    }

    public function multiplyBy(int|self $amount): self
    {
        if ($amount instanceof self) {
            return new self($this->value * $amount->value);
        }

        return new self($this->value * $amount);
    }
}
