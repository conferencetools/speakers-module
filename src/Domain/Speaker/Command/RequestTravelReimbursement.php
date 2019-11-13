<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use JMS\Serializer\Annotation as Jms;
use Phactor\Message\HasActorId;

class RequestTravelReimbursement implements HasActorId
{
    /** @Jms\Type("string") */
    private $speakerId;
    /** @Jms\Type("integer") */
    private $amount;
    /** @Jms\Type("string") */
    private $notes;
    /** @Jms\Type("string") */
    private $file;

    public function __construct(string $speakerId, int $amount, string $notes, ?string $file)
    {
        $this->speakerId = $speakerId;
        $this->amount = $amount;
        $this->notes = $notes;
        $this->file = $file;
    }

    public function getActorId(): string
    {
        return $this->speakerId;
    }

    public function getSpeakerId(): string
    {
        return $this->speakerId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }
}