<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

enum MessagePattern: string
{
    case Catchup = MessageType::CatchupRequest->value . ' %s %s %s %s';
    case Acknowledgement = MessageType::Acknowledgement->value . ' %s %s %s %s %d %d';
    case NewEvent = MessageType::NewEvent->value . ' %s';
    case NewEventAccepted = MessageType::NewEventAccepted->value . ' %s %d';
    case NewEventRejected = MessageType::NewEventRejected->value . ' %s %d';
    case ProvideIdentity = MessageType::ProvideIdentity->value . ' %s %s %s';
    case ReadStream = MessageType::ReadStream->value . ' %s %s %d %d';
    case RejectEvent = MessageType::RejectEvent->value . ' %s %s %s %s';
    case WriteNewEvent = MessageType::WriteNewEvent->value . ' %s %s %s %s %d';
}
