<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;
use ConferenceTools\Speakers\Domain\Speaker\Talk;

class AdditionalTalkWasAdded
{
    /**
     * @Jms\Type("string")
     */
    private $id;
    /**
     * @Jms\Type("string")
     */
    private $talkId;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Talk")
     */
    private $talk;

    public function __construct(string $id, int $talkId, Talk $talk)
    {
        $this->id = $id;
        $this->talkId = $talkId;
        $this->talk = $talk;
    }

    public function getId(): string
    {
        return $this->id;
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
