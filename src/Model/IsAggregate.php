<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

interface IsAggregate
{
    public function id(): AggregateId;

    /**
     * @return array[]
     */
    public function newEvents(): array;

    public function clearNewEvents(): void;

    public function applyEvent(IsEvent $event, int $currentVersion): void;

    public static function streamName(): StreamName;

    public function setCurrentVersion(int $currentVersion): void;

    public function getCurrentVersion(): int;

    public function nextVersion(): int;

    public function isEmpty(): bool;

    public static function streamId(AggregateId $id): StreamId;
}
