<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use Phactor\Message\HasActorId;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use JMS\Serializer\Annotation as Jms;

class UpdateTalk implements HasActorId
{
    /**
     * @Jms\Type("string")
     */
    private $actorId;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Talk")
     */
    private $talk;
    /**
     * @Jms\Type("integer")
     */
    private $talkId;

    public function __construct(string $actorId, int $talkId, Talk $talk)
    {
        $this->actorId = $actorId;
        $this->talk = $talk;
        $this->talkId = $talkId;
    }

    public function getActorId(): string
    {
        return $this->actorId;
    }

    public function getTalkId(): int
    {
        return $this->talkId;
    }

    public function getTalk(): Talk
    {
        return $this->talk;
    }
}
