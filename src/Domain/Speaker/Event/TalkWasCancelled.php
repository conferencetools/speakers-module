<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;

class TalkWasCancelled
{
    /**
     * @Jms\Type("string")
     */
    private $speakerId;
    /**
     * @Jms\Type("integer")
     */
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
