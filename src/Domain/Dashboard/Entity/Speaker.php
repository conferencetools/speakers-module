<?php


namespace ConferenceTools\Speakers\Domain\Dashboard\Entity;

use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\DietaryRequirements;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use ConferenceTools\Speakers\Domain\Speaker\Journey as JourneyVO;
use ConferenceTools\Speakers\Domain\Speaker\Talk as TalkVO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity()
*/
class Speaker
{
    const ACCOMMODATION_REQUESTED = 'Requested';
    const ACCOMMODATION_BOOKED = 'Booked';
    /**
     * @ORM\Id @ORM\Column(type="string")
     */
    private $identity;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     */
    private $company;
    /**
     * @ORM\Column(type="string")
     */
    private $twitter;
    /**
     * @ORM\Column(type="text")
     */
    private $aboutMe;
    /**
     * @ORM\Column(type="text")
     */
    private $specialRequirements = '';
    /**
     * @ORM\Column(type="boolean")
     */
    private $responded = false;
    /**
     * @ORM\Column(type="boolean")
     */
    private $accepted = false;
    /**
     * @var Talk[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="ConferenceTools\Speakers\Domain\Dashboard\Entity\Talk",
     *     mappedBy="speaker",
     *     indexBy="index",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     *     )
     */
    private $talks;

    /**
     * @var Journey[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="ConferenceTools\Speakers\Domain\Dashboard\Entity\Journey",
     *     mappedBy="speaker",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     *     )
     */
    private $journeys;
    /**
     * @var TravelReimbursement[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="ConferenceTools\Speakers\Domain\Dashboard\Entity\TravelReimbursement",
     *     mappedBy="speaker",
     *     indexBy="reimbursementRequestId",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     *     )
     */
    private $travelReimbursements;
    /**
     * @var PickupRequest[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="ConferenceTools\Speakers\Domain\Dashboard\Entity\PickupRequest",
     *     mappedBy="speaker",
     *     indexBy="pickupRequestId",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     *     )
     */
    private $pickupRequests;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $preference;
    /**
     * @ORM\Column(type="string")
     */
    private $allergies = '';
    /** @ORM\Column(type="json_array") */
    private $accommodation = [];
    /** @ORM\Column(type="boolean") */
    private $accommodationRequested = false;


    public function __construct(string $identity, string $name, Email $email, Bio $bio)
    {
        $this->identity = $identity;
        $this->name = $name;
        $this->email = $email->getEmail();
        $this->company = $bio->getCompanyName();
        $this->twitter = $bio->getTwitterHandle();
        $this->aboutMe = $bio->getAboutMe();
        $this->talks = new ArrayCollection();
        $this->journeys = new ArrayCollection();
        $this->travelReimbursements = new ArrayCollection();
        $this->pickupRequests = new ArrayCollection();
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getTwitter()
    {
        return $this->twitter;
    }

    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    public function getTalks()
    {
        return $this->talks;
    }

    public function getSpecialRequirements()
    {
        return $this->specialRequirements;
    }

    public function getPreference()
    {
        return $this->preference;
    }

    public function getAllergies()
    {
        return $this->allergies;
    }

    public function addTalk(int $index, TalkVO $talk)
    {
        $this->talks->add(new Talk($this, $index, $talk));
    }

    public function accepted()
    {
        $this->responded = true;
        $this->accepted = true;
    }

    public function declined()
    {
        $this->responded = true;
        $this->accepted = false;
    }

    public function hasResponded()
    {
        return $this->responded;
    }

    public function hasAccepted()
    {
        return $this->accepted;
    }

    public function getTalk(int $talkId): Talk
    {
        return $this->talks->get($talkId);
    }

    public function updateTalk(int $talkId, TalkVO $newTalk)
    {
        $talk = $this->getTalk($talkId);
        $talk->update($newTalk->getTitle(), $newTalk->getAbstract());
    }

    public function updateProfile(string $name, Email $email, Bio $bio, string $specialRequirements, DietaryRequirements $dietaryRequirements)
    {
        $this->name = $name;
        $this->email = $email->getEmail();
        $this->company = $bio->getCompanyName();
        $this->twitter = $bio->getTwitterHandle();
        $this->aboutMe = $bio->getAboutMe();
        $this->specialRequirements = $specialRequirements;
        $this->preference = $dietaryRequirements->getPreference();
        $this->allergies = $dietaryRequirements->getAllergies();
    }

    public function addJourney(JourneyVO $journey)
    {
        $this->journeys->add(new Journey($this, $journey));
    }

    public function getJourneys()
    {
        return $this->journeys;
    }

    public function cancelTalk(int $talkNumber)
    {
        $talk = $this->getTalk($talkNumber);
        $this->talks->removeElement($talk);
    }

    public function addTravelReimbursement(string $reimbursementRequestId, int $amount, string $notes, string $fileId)
    {
        $travelReimbursement = new TravelReimbursement($this, $reimbursementRequestId, $amount, $notes, $fileId);
        $this->travelReimbursements->add($travelReimbursement);
    }

    public function getTravelReimbursements()
    {
        return $this->travelReimbursements;
    }

    public function getTravelReimbursement(string $id): TravelReimbursement
    {
        return $this->travelReimbursements->get($id);
    }

    public function addPickupRequest(string $pickupRequestId, string $station, \DateTime $pickupTime, string $notes)
    {
        $pickupRequest = new PickupRequest($this, $pickupRequestId, $station, $pickupTime, $notes);
        $this->pickupRequests->add($pickupRequest);
    }

    public function getPickupRequests()
    {
        return $this->pickupRequests;
    }

    public function getPickupRequest(string $id): PickupRequest
    {
        return $this->pickupRequests->get($id);
    }

    public function accommodationRequested(string ...$dates): void
    {
        $this->accommodationRequested = true;
        foreach ($dates as $date) {
            if (!isset($this->accomodation[$date])) {
                $this->accommodation[$date] = self::ACCOMMODATION_REQUESTED;
            }
        }
    }

    public function accommodationBooked(string ...$dates): void
    {
        $this->accommodationRequested = true;
        foreach ($dates as $date) {
            $this->accommodation[$date] = self::ACCOMMODATION_BOOKED;
        }
    }

    public function getAccommodation(): array
    {
        return $this->accommodation;
    }

    public function hasRequestedAccommodation(): bool
    {
        return $this->accommodationRequested;
    }
}