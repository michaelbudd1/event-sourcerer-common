<?php

declare(strict_types=1);

namespace PearTreeWeb\EventSourcerer\Common\Model;

enum MessageMarkup: String
{
    case NewEventParser     = '--- SYSTEM NEW EVENT ---';
    case RejectedEventStart = '--- REJECTED EVENT START ---';
    case RejectedEventEnd   = '--- REJECTED EVENT END ---';
}
