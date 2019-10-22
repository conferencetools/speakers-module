<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;
use Phactor\Message\HasActorId;

class StationPickupRequested
{
    /** @Jms\Type("string") */
    protected $speakerId;
    /** @Jms\Type("string") */
    private $pickupRequestId;
    /** @Jms\Type("string") */
    protected $station;
    /** @Jms\Type("DateTime") */
    protected $pickupTime;
    /** @Jms\Type("string") */
    protected $notes;

    public function __construct(string $speakerId, string $pickupRequestId, string $station, \DateTime $pickupTime, string $notes)
    {
        $this->speakerId = $speakerId;
        $this->station = $station;
        $this->pickupTime = $pickupTime;
        $this->notes = $notes;
        $this->pickupRequestId = $pickupRequestId;
    }

    public function getSpeakerId(): string
    {
        return $this->speakerId;
    }

    public function getPickupRequestId(): string
    {
        return $this->pickupRequestId;
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