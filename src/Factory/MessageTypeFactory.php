<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Factory;

use PearTreeWeb\EventSourcerer\Common\Exception\CouldNotCreateMessageType;
use PearTreeWeb\EventSourcerer\Common\MessageType;

final class MessageTypeFactory
{
    public static function fromMessage(string $data): MessageType
    {
        $messageParts = explode(' ', $data);

        $type = MessageType::tryFrom($messageParts[0]);

        if (null === $type) {
            throw CouldNotCreateMessageType::becauseTypeIsUnknown($messageParts[0], $data);
        }

        return $type;
    }
}
