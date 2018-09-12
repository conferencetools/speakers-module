<?php

namespace ConferenceTools\Speakers\Domain\Speaker;

use JMS\Serializer\Annotation as Jms;

class Email
{
    /**
     * @Jms\Type("string")
     */
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
