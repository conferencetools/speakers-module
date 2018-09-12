<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;

class SpeakerDeclinedInvitation
{
    /**
     * @Jms\Type("string")
     */
    private $identity;

    public function __construct(string $identity)
    {
        $this->identity = $identity;
    }

    public function getIdentity()
    {
        return $this->identity;
    }
}