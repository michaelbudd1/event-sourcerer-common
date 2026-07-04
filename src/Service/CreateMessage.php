<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Service;

use PearTreeWeb\EventSourcerer\Common\Model\ApplicationId;
use PearTreeWeb\EventSourcerer\Common\Model\ApplicationType;
use PearTreeWeb\EventSourcerer\Common\Model\Checkpoint;
use PearTreeWeb\EventSourcerer\Common\Model\EventName;
use PearTreeWeb\EventSourcerer\Common\Model\EventVersion;
use PearTreeWeb\EventSourcerer\Common\Model\Message;
use PearTreeWeb\EventSourcerer\Common\Model\MessageMarkup;
use PearTreeWeb\EventSourcerer\Common\Model\MessagePattern;
use PearTreeWeb\EventSourcerer\Common\Model\StreamId;
use PearTreeWeb\EventSourcerer\Common\Model\WorkerId;

final readonly class CreateMessage
{
    public static function forWriteNewEvent(
        StreamId $streamId,
        EventName $eventName,
        EventVersion $eventVersion,
        array $payload,
        ?int $expectedCurrentVersion = 0,
    ): Message {
        return Message::fromString(
            sprintf(
                MessagePattern::WriteNewEvent->value,
                $streamId,
                $eventName,
                $eventVersion,
                json_encode($payload, JSON_THROW_ON_ERROR),
                $expectedCurrentVersion,
            ) . MessageMarkup::NewEventParser->value
        );
    }

    public static function forNewEvent(string $eventJson): Message
    {
        return Message::fromString(
            sprintf(
                MessagePattern::NewEvent->value,
                $eventJson,
            ) . MessageMarkup::NewEventParser->value
        );
    }

    public static function forAcceptanceOfNewEvent(StreamId $streamId, Checkpoint $checkpoint): Message
    {
        return Message::fromString(
            sprintf(
                MessagePattern::NewEventAccepted->value,
                $streamId,
                $checkpoint->toInt(),
            )
        );
    }

    public static function forRejectionOfNewEvent(StreamId $streamId, Checkpoint $checkpoint): Message
    {
        return Message::fromString(
            sprintf(
                MessagePattern::NewEventRejected->value,
                $streamId,
                $checkpoint->toInt(),
            )
        );
    }

    public static function forCatchupRequest(
        StreamId $streamId,
        ApplicationId $applicationId,
        WorkerId $workerId,
        ?Checkpoint $checkpoint = null
    ): Message {
        return Message::fromString(
            sprintf(
                MessagePattern::Catchup->value,
                $streamId,
                $applicationId,
                $workerId->toString(),
                $checkpoint?->toString() ?? ''
            ) . MessageMarkup::NewEventParser->value
        );
    }

    public static function forProvidingIdentity(
        ApplicationId $applicationId,
        ApplicationType $applicationType,
        WorkerId $workerId
    ): Message {
        return Message::fromString(
            sprintf(
                MessagePattern::ProvideIdentity->value,
                $applicationId,
                $applicationType->value,
                $workerId
            ). MessageMarkup::NewEventParser->value
        );
    }

    public static function forAcknowledgement(
        StreamId $streamId,
        StreamId $catchupStreamId,
        ApplicationId $applicationId,
        WorkerId $workerId,
        Checkpoint $checkpoint,
        Checkpoint $allStreamCheckpoint
    ): Message {
        return Message::fromString(
            sprintf(
                MessagePattern::Acknowledgement->value,
                $streamId,
                $catchupStreamId,
                $applicationId,
                $workerId,
                $checkpoint->toInt(),
                $allStreamCheckpoint->toInt()
            ) . MessageMarkup::NewEventParser->value
        );
    }

    public static function forRejection(
        StreamId $streamId,
        ApplicationId $applicationId,
        Checkpoint $checkpoint,
        string $originalMessage
    ): Message {
        return Message::fromString(
            sprintf(
                MessagePattern::RejectEvent->value,
                $streamId,
                $applicationId,
                $checkpoint->toString(),
                self::parseOriginalEvent($originalMessage)
            ) . MessageMarkup::NewEventParser->value
        );
    }

    public static function forReadingStream(
        StreamId $streamId,
        ApplicationId $applicationId,
        ?Checkpoint $start = null,
        ?Checkpoint $end = null,
    ): Message {
        return Message::fromString(
            sprintf(
                MessagePattern::ReadStream->value,
                $streamId,
                $applicationId,
                $start?->toString() ?? '',
                $end?->toString() ?? '',
            ) . MessageMarkup::NewEventParser->value
        );
    }

    private static function parseOriginalEvent(string $originalMessage): string
    {
        return sprintf(
            '%s %s %s',
            MessageMarkup::RejectedEventStart->value,
            $originalMessage,
            MessageMarkup::RejectedEventEnd->value
        );
    }
}
