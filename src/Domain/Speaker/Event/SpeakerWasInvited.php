<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use JMS\Serializer\Annotation as Jms;

class SpeakerWasInvited
{
    /**
     * @Jms\Type("string")
     */
    private $identity;
    /**
     * @Jms\Type("string")
     */
    private $name;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Email")
     */
    private $email;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Bio")
     */
    private $bio;

    public function __construct(string $identity, string $name, Bio $bio, Email $email)
    {
        $this->identity = $identity;
        $this->name = $name;
        $this->bio = $bio;
        $this->email = $email;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBio(): Bio
    {
        return $this->bio;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}