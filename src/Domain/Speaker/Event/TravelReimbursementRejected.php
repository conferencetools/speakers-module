<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use JMS\Serializer\Annotation as Jms;
use Phactor\Message\HasActorId;

class TravelReimbursementRejected
{
    /** @Jms\Type("string") */
    private $speakerId;
    /** @Jms\Type("string") */
    private $reimbursementRequestId;
    /** @Jms\Type("string") */
    private $reason;

    public function __construct(string $speakerId, string $reimbursementRequestId, string $reason)
    {
        $this->speakerId = $speakerId;
        $this->reimbursementRequestId = $reimbursementRequestId;
        $this->reason = $reason;
    }

    public function getSpeakerId(): string
    {
        return $this->speakerId;
    }

    public function getReimbursementRequestId(): string
    {
        return $this->reimbursementRequestId;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}