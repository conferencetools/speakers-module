<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use Carnage\Phactor\Message\HasActorId;
use ConferenceTools\Speakers\Domain\Speaker\Talk;

class UpdateTalk implements HasActorId
{
    private $actorId;
    private $talk;
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
