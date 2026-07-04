<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

enum MessageType: string
{
    case Acknowledgement = 'ACKNOWLEDGEMENT';
    case CatchupRequest = 'CATCHUP';
    case NewEvent = 'NEW_EVENT';
    case NewEventAccepted = 'NEW_EVENT_ACCEPTED';
    case NewEventRejected = 'NEW_EVENT_REJECTED';
    case ProvideIdentity = 'IDENTITY';
    case ReadStream = 'READ_STREAM';
    case RejectEvent = 'REJECT_EVENT';
    case WriteNewEvent = 'WRITE_NEW_EVENT';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
