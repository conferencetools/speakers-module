<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use Carnage\Phactor\Message\HasActorId;
use ConferenceTools\Speakers\Domain\Speaker\Journey;
use JMS\Serializer\Annotation as Jms;

class ProvideJourneyDetails implements HasActorId
{
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Journey")
     */
    private $journey;
    /**
     * @Jms\Type("string")
     */
    private $actorId;

    public function __construct(string $actorId, Journey $journey)
    {
        $this->journey = $journey;
        $this->actorId = $actorId;
    }

    public function getActorId(): string
    {
        return $this->actorId;
    }

    public function getJourney(): Journey
    {
        return $this->journey;
    }
}