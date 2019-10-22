<?php

namespace ConferenceTools\Speakers\Domain\Dashboard\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity() */
class PickupRequest
{
    const REQUESTED = 'Requested';
    const ACCEPTED = 'Accepted';
    const REJECTED = 'Rejected';
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker", inversedBy="pickupRequests")
     * @ORM\JoinColumn(name="speaker_id", referencedColumnName="identity")
     */
    private $speaker;
    /** @ORM\Column(type="string") @ORM\Id() */
    private $pickupRequestId;
    /** @ORM\Column(type="string") */
    private $station;
    /** @ORM\Column(type="datetime") */
    private $pickupTime;
    /** @ORM\Column(type="string") */
    private $status = self::REQUESTED;
    /** @ORM\Column(type="string") */
    private $requestNotes = '';
    /** @ORM\Column(type="string") */
    private $rejectReason = '';
    /** @ORM\Column(type="string") */
    private $acceptNotes = '';

    public function __construct(Speaker $speaker, string $pickupRequestId, string $station, \DateTime $pickupTime, string $requestNotes)
    {
        $this->speaker = $speaker;
        $this->pickupRequestId = $pickupRequestId;
        $this->station = $station;
        $this->pickupTime = $pickupTime;
        $this->requestNotes = $requestNotes;
    }

    public function getSpeaker(): Speaker
    {
        return $this->speaker;
    }

    public function getPickupRequestId(): string
    {
        return $this->pickupRequestId;
    }

    public function getStation(): string
    {
        return $this->station;
    }

    public function getPickupTime(): \DateTime
    {
        return $this->pickupTime;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getRequestNotes(): string
    {
        return $this->requestNotes;
    }

    public function getRejectReason(): string
    {
        return $this->rejectReason;
    }

    public function getAcceptNotes(): string
    {
        return $this->acceptNotes;
    }

    public function isRequested(): bool
    {
        return $this->status === self::REQUESTED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::REJECTED;
    }

    public function isAccepted(): bool
    {
        return $this->status === self::ACCEPTED;
    }

    public function accept(string $notes): void
    {
        $this->acceptNotes = $notes;
        $this->status = self::ACCEPTED;
    }

    public function reject(string $reason): void
    {
        $this->rejectReason = $reason;
        $this->status = self::REJECTED;
    }
}