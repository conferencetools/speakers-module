<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use JMS\Serializer\Annotation as Jms;
use Phactor\Message\HasActorId;

class PayTravelReimbursement implements HasActorId
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

    public function getActorId(): string
    {
        return $this->speakerId;
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