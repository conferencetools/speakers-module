<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Command;


use Carnage\Phactor\Message\HasActorId;

class CancelTalk implements HasActorId
{
    private $speakerId;
    private $talkNumber;

    public function __construct(string $speakerId, int $talkNumber)
    {
        $this->speakerId = $speakerId;
        $this->talkNumber = $talkNumber;
    }

    public function getActorId(): string
    {
        return $this->speakerId;
    }

    public function getTalkNumber(): int
    {
        return $this->talkNumber;
    }
}
