<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use JMS\Serializer\Annotation as Jms;

class InviteToSpeak
{
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