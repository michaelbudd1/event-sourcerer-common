<?php

namespace PearTreeWeb\EventSourcerer\Common\Service;

use PearTreeWeb\EventSourcerer\Common\Model\EventName;

interface ProvideEventClassPath
{
    public function for(EventName $eventName): string;
}
