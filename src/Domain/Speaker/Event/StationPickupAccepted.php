<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;
use Phactor\Message\HasActorId;

class StationPickupAccepted
{
    /** @Jms\Type("string") */
    private $speakerId;
    /** @Jms\Type("string") */
    private $pickupRequestId;
    /** @Jms\Type("string") */
    private $notes;

    public function __construct(string $speakerId, string $pickupRequestId, string $notes)
    {
        $this->speakerId = $speakerId;
        $this->pickupRequestId = $pickupRequestId;
        $this->notes = $notes;
    }

    public function getSpeakerId(): string
    {
        return $this->speakerId;
    }

    public function getPickupRequestId(): string
    {
        return $this->pickupRequestId;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }
}