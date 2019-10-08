<?php


namespace ConferenceTools\Speakers\Domain\Dashboard\Entity;

use Doctrine\ORM\Mapping as ORM;
use ConferenceTools\Speakers\Domain\Speaker\Journey as JourneyVO;

/**
 * @ORM\Entity()
 */
class Journey
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker", inversedBy="talks")
     * @ORM\JoinColumn(name="speaker_id", referencedColumnName="identity")
     */
    private $speaker;

    /**
     * @ORM\Column(type="string")
     */
    private $arriveAt;
    /**
     * @ORM\Column(type="string")
     */
    private $departFrom;
    /**
     * @ORM\Column(type="datetime")
     */
    private $arrivalTime;
    /**
     * @ORM\Column(type="datetime")
     */
    private $departureTime;
    /**
     * @ORM\Column(type="string")
     */
    private $notes;

    public function __construct(Speaker $speaker, JourneyVO $journey)
    {
        $this->speaker = $speaker;
        $this->arrivalTime = $journey->getArrivalTime();
        $this->arriveAt = $journey->getArriveAt();
        $this->departureTime = $journey->getDepartureTime();
        $this->departFrom = $journey->getDepartFrom();
        $this->notes = $journey->getNotes();
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