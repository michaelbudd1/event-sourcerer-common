<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Exception;

final class ValueIsNotRecognisedIpAddressException extends \RuntimeException
{
    public static function withValue(string $value): self
    {
        return new self(
            sprintf(
            'Value "%s" is not recognised as an IP address',
                $value
            )
        );
    }
}
