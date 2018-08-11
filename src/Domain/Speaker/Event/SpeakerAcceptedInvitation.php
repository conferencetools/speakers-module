<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Event;


class SpeakerAcceptedInvitation
{
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