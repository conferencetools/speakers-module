<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;
use ConferenceTools\Speakers\Domain\Speaker\Journey;

class JourneyDetailsProvided
{
    /**
     * @Jms\Type("string")
     */
    private $id;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Journey")
     */
    private $journey;

    public function __construct(string $id, Journey $journey)
    {
        $this->id = $id;
        $this->journey = $journey;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getJourney(): Journey
    {
        return $this->journey;
    }
}