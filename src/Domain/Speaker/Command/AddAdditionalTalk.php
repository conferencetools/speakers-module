<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Command;


use Carnage\Phactor\Message\HasActorId;
use ConferenceTools\Speakers\Domain\Speaker\Talk;

class AddAdditionalTalk implements HasActorId
{
    private $actorId;
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
