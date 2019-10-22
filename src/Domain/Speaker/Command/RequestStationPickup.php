<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use JMS\Serializer\Annotation as Jms;
use Phactor\Message\HasActorId;

class RequestStationPickup implements HasActorId
{
    /** @Jms\Type("string") */
    protected $speakerId;
    /** @Jms\Type("string") */
    protected $station;
    /** @Jms\Type("DateTime") */
    protected $pickupTime;
    /** @Jms\Type("string") */
    protected $notes;

    public function __construct(string $speakerId, string $station, \DateTime $pickupTime, string $notes)
    {
        $this->speakerId = $speakerId;
        $this->station = $station;
        $this->pickupTime = $pickupTime;
        $this->notes = $notes;
    }

    public function getActorId(): string
    {
        return $this->speakerId;
    }

    public function getSpeakerId(): string
    {
        return $this->speakerId;
    }

    public function getStation(): string
    {
        return $this->station;
    }

    public function getPickupTime(): \DateTime
    {
        return $this->pickupTime;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }
}