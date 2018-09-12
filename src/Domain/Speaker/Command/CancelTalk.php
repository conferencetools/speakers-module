<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Command;


use Carnage\Phactor\Message\HasActorId;
use JMS\Serializer\Annotation as Jms;

class CancelTalk implements HasActorId
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

    public function getActorId(): string
    {
        return $this->speakerId;
    }

    public function getTalkNumber(): int
    {
        return $this->talkNumber;
    }
}
