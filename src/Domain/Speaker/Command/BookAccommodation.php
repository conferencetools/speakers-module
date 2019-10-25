<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use JMS\Serializer\Annotation as Jms;
use Phactor\Message\HasActorId;

class BookAccommodation implements HasActorId
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

    public function getActorId(): string
    {
        return $this->speakerId;
    }
}