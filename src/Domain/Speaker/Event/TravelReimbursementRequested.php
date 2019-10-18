<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;

class TravelReimbursementRequested
{
    /** @Jms\Type("string") */
    private $speakerId;
    /** @Jms\Type("integer") */
    private $amount;
    /** @Jms\Type("string") */
    private $notes;
    /** @Jms\Type("string") */
    private $file;
    /** @Jms\Type("string") */
    private $reimbursementRequestId;

    public function __construct(string $speakerId, int $amount, string $notes, string $file, string $reimbursementRequestId)
    {
        $this->speakerId = $speakerId;
        $this->amount = $amount;
        $this->notes = $notes;
        $this->file = $file;
        $this->reimbursementRequestId = $reimbursementRequestId;
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

    public function getFile(): string
    {
        return $this->file;
    }

    public function getReimbursementRequestId(): string
    {
        return $this->reimbursementRequestId;
    }
}