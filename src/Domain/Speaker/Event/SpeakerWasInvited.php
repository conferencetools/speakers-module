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
     * @Jms\Type("array<ConferenceTools\Speakers\Domain\Speaker\Talk>")
     */
    private $talks;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Bio")
     */
    private $bio;

    public function __construct(string $identity, string $name, Bio $bio, Email $email, Talk ...$talks)
    {
        $this->identity = $identity;
        $this->name = $name;
        $this->bio = $bio;
        $this->email = $email;
        $this->talks = $talks;
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

    public function getTalks(): array
    {
        return $this->talks;
    }
}