<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

use PearTreeWeb\EventSourcerer\Common\Exception\ValueIsNotRecognisedIpAddressException;

final class IPAddress implements IsString
{
    use FulfilIsString;

    protected static function validate(?string $value): void
    {
        if (false === filter_var($value, FILTER_VALIDATE_IP)) {
            throw ValueIsNotRecognisedIpAddressException::withValue((string) $value);
        }
    }
}
