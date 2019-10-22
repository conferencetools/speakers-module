<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;
use Phactor\Message\HasActorId;

class StationPickupRejected
{
    /** @Jms\Type("string") */
    private $speakerId;
    /** @Jms\Type("string") */
    private $pickupRequestId;
    /** @Jms\Type("string") */
    private $reason;

    public function __construct(string $speakerId, string $pickupRequestId, string $reason)
    {
        $this->speakerId = $speakerId;
        $this->pickupRequestId = $pickupRequestId;
        $this->reason = $reason;
    }

    public function getSpeakerId(): string
    {
        return $this->speakerId;
    }

    public function getPickupRequestId(): string
    {
        return $this->pickupRequestId;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}