<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;

class AccommodationRequested
{
    /** @Jms\Type("string") */
    private $speakerId;
    /** @Jms\Type("array") */
    private $dates;

    public function __construct(string $speakerId, string ...$dates)
    {
        $this->speakerId = $speakerId;
        $this->dates = $dates;
    }

    public function getSpeakerId(): string
    {
        return $this->speakerId;
    }

    public function getDates(): array
    {
        return $this->dates;
    }
}