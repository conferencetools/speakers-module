<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use Carnage\Phactor\Message\HasActorId;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use JMS\Serializer\Annotation as Jms;

class AddAdditionalTalk implements HasActorId
{
    /**
     * @Jms\Type("string")
     */
    private $actorId;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Talk")
     */
    private $talk;

    public function __construct(string $actorId, Talk $talk)
    {
        $this->actorId = $actorId;
        $this->talk = $talk;
    }

    public function getActorId(): string
    {
        return $this->actorId;
    }

    public function getTalk(): Talk
    {
        return $this->talk;
    }
}
