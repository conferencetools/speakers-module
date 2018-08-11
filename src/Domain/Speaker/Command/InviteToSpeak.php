<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use ConferenceTools\Speakers\Domain\Speaker\Talk;

class InviteToSpeak
{
    private $name;
    private $email;
    private $talks;
    private $bio;

    public function __construct(string $name, Bio $bio, Email $email, Talk ...$talks)
    {
        $this->name = $name;
        $this->email = $email;
        $this->talks = $talks;
        $this->bio = $bio;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getTalks(): array
    {
        return $this->talks;
    }

    public function getBio(): Bio
    {
        return $this->bio;
    }
}