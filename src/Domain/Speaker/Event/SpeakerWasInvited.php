<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use ConferenceTools\Speakers\Domain\Speaker\Email;

class SpeakerWasInvited
{
    private $identity;
    private $name;
    private $bio;
    private $email;
    private $talks;

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