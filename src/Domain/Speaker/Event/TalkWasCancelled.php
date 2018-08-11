<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Event;


class TalkWasCancelled
{
    private $speakerId;
    private $talkNumber;

    public function __construct(string $speakerId, int $talkNumber)
    {
        $this->speakerId = $speakerId;
        $this->talkNumber = $talkNumber;
    }

    public function getSpeakerId(): string
    {
        return $this->speakerId;
    }

    public function getTalkNumber(): int
    {
        return $this->talkNumber;
    }
}
