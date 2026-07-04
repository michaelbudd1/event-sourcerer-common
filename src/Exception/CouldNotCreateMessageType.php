<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Exception;

use PearTreeWeb\EventSourcerer\Common\MessageType;

final class CouldNotCreateMessageType extends \RuntimeException
{
    public static function becauseTypeIsUnknown(string $type, string $fullMessage): self
    {
        return new self(
            sprintf(
                'Could not create message type because type "%s" is unknown. Known types are: %s. Full message was: %s',
                $type,
                implode(', ', MessageType::values()),
                $fullMessage
            )
        );
    }
}
