<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;
use Phactor\Message\HasActorId;

class TravelReimbursementPaid
{
    /** @Jms\Type("string") */
    private $speakerId;
    /** @Jms\Type("string") */
    private $reimbursementRequestId;
    /** @Jms\Type("string") */
    private $notes;

    public function __construct(string $speakerId, string $reimbursementRequestId, string $notes)
    {
        $this->speakerId = $speakerId;
        $this->reimbursementRequestId = $reimbursementRequestId;
        $this->notes = $notes;
    }

    public function getSpeakerId(): string
    {
        return $this->speakerId;
    }

    public function getReimbursementRequestId(): string
    {
        return $this->reimbursementRequestId;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }
}