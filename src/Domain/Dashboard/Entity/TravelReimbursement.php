<?php


namespace ConferenceTools\Speakers\Domain\Dashboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class TravelReimbursement
{
    private const REQUESTED = 'Requested';
    private const ACCEPTED = 'Accepted';
    private const REJECTED = 'Rejected';
    private const PAID = 'Paid';
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker", inversedBy="talks")
     * @ORM\JoinColumn(name="speaker_id", referencedColumnName="identity")
     */
    private $speaker;
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", name="reimbursementRequestId")
     */
    private $reimbursementRequestId;
    /**
     * @ORM\Column(type="integer")
     */
    private $amount;
    /**
     * @ORM\Column(type="string")
     */
    private $status = 'Requested';
    /**
     * @ORM\Column(type="string")
     */
    private $requestNotes = '';
    /**
     * @ORM\Column(type="string")
     */
    private $acceptNotes = '';
    /**
     * @ORM\Column(type="string")
     */
    private $paymentNotes = '';
    /**
     * @ORM\Column(type="string")
     */
    private $rejectReason = '';

    public function __construct(Speaker $speaker, string $reimbursementRequestId, int $amount, string $requestNotes)
    {
        $this->speaker = $speaker;
        $this->reimbursementRequestId = $reimbursementRequestId;
        $this->amount = $amount;
        $this->requestNotes = $requestNotes;
    }

    public function getSpeaker(): Speaker
    {
        return $this->speaker;
    }

    public function getReimbursementRequestId(): string
    {
        return $this->reimbursementRequestId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getRequestNotes(): string
    {
        return $this->requestNotes;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAcceptNotes(): string
    {
        return $this->acceptNotes;
    }

    public function getPaymentNotes(): string
    {
        return $this->paymentNotes;
    }

    public function getRejectReason(): string
    {
        return $this->rejectReason;
    }

    public function reject(string $reason): void
    {
        $this->rejectReason = $reason;
        $this->status = self::REJECTED;
    }

    public function accept(string $notes): void
    {
        $this->acceptNotes = $notes;
        $this->status = self::ACCEPTED;
    }

    public function pay(string $notes): void
    {
        $this->paymentNotes = $notes;
        $this->status = self::PAID;
    }

    public function isAccepted(): bool
    {
        return $this->status === self::ACCEPTED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::REJECTED;
    }

    public function isRequested(): bool
    {
        return $this->status === self::REQUESTED;
    }

    public function isPaid(): bool
    {
        return $this->status === self::PAID;
    }
}