<?php


namespace ConferenceTools\Speakers\Domain\Speaker;


class Journey
{
    private $arriveAt;

    private $departFrom;

    private $arrivalTime;

    private $departureTime;

    private $notes;

    public function __construct(string $arriveAt, string $departFrom, \DateTime $arrivalTime, \DateTime $departureTime, string $notes)
    {
        $this->arriveAt = $arriveAt;
        $this->departFrom = $departFrom;
        $this->arrivalTime = $arrivalTime;
        $this->departureTime = $departureTime;
        $this->notes = $notes;
    }

    public function getArriveAt(): string
    {
        return $this->arriveAt;
    }

    public function getDepartFrom(): string
    {
        return $this->departFrom;
    }

    public function getArrivalTime(): \DateTime
    {
        return $this->arrivalTime;
    }

    public function getDepartureTime(): \DateTime
    {
        return $this->departureTime;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }
}