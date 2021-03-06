<?php

namespace ConferenceTools\Speakers\Domain\Speaker;

use ConferenceTools\Speakers\Domain\Speaker\Command\AcceptStationPickupRequest;
use ConferenceTools\Speakers\Domain\Speaker\Command\AcceptTravelReimbursement;
use ConferenceTools\Speakers\Domain\Speaker\Command\BookAccommodation;
use ConferenceTools\Speakers\Domain\Speaker\Command\PayTravelReimbursement;
use ConferenceTools\Speakers\Domain\Speaker\Command\RejectStationPickupRequest;
use ConferenceTools\Speakers\Domain\Speaker\Command\RejectTravelReimbursement;
use ConferenceTools\Speakers\Domain\Speaker\Command\RequestAccommodation;
use ConferenceTools\Speakers\Domain\Speaker\Command\RequestStationPickup;
use ConferenceTools\Speakers\Domain\Speaker\Command\RequestTravelReimbursement;
use ConferenceTools\Speakers\Domain\Speaker\Event\AccommodationBooked;
use ConferenceTools\Speakers\Domain\Speaker\Event\AccommodationRequested;
use ConferenceTools\Speakers\Domain\Speaker\Event\StationPickupAccepted;
use ConferenceTools\Speakers\Domain\Speaker\Event\StationPickupRejected;
use ConferenceTools\Speakers\Domain\Speaker\Event\StationPickupRequested;
use ConferenceTools\Speakers\Domain\Speaker\Event\TravelReimbursementAccepted;
use ConferenceTools\Speakers\Domain\Speaker\Event\TravelReimbursementPaid;
use ConferenceTools\Speakers\Domain\Speaker\Event\TravelReimbursementRejected;
use ConferenceTools\Speakers\Domain\Speaker\Event\TravelReimbursementRequested;
use Phactor\Actor\AbstractActor;
use ConferenceTools\Speakers\Domain\Speaker\Command\AcceptInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Command\AddAdditionalTalk;
use ConferenceTools\Speakers\Domain\Speaker\Command\CancelTalk;
use ConferenceTools\Speakers\Domain\Speaker\Command\DeclineInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Command\InviteToSpeak;
use ConferenceTools\Speakers\Domain\Speaker\Command\ProvideJourneyDetails;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateProfile;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateTalk;
use ConferenceTools\Speakers\Domain\Speaker\Event\AdditionalTalkWasAdded;
use ConferenceTools\Speakers\Domain\Speaker\Event\JourneyDetailsProvided;
use ConferenceTools\Speakers\Domain\Speaker\Event\ProfileWasUpdated;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerAcceptedInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerDeclinedInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerWasInvited;
use ConferenceTools\Speakers\Domain\Speaker\Event\TalkWasCancelled;
use ConferenceTools\Speakers\Domain\Speaker\Event\TalkWasUpdated;

class Speaker extends AbstractActor
{
    private const REIMBURSEMENT_REQUESTED = 'reimbursement-requested';
    private const REIMBURSEMENT_REJECTED = 'reimbursement-rejected';
    private const REIMBURSEMENT_ACCEPTED = 'reimbursement-accepted';
    private const REIMBURSEMENT_PAID = 'reimbursement-paid';
    const PICKUP_REQUESTED = 'pickup-requested';
    const PICKUP_REJECTED = 'pickup-rejected';
    const PICKUP_ACCEPTED = 'pickup-accepted';
    const ACCOMMODATION_REQUESTED = 'accommodation-requested';
    const ACCOMMODATION_BOOKED = 'accommodation-booked';

    private $email;
    private $name;
    private $talks = [];
    private $bio;
    private $accepted;
    private $journeys;
    private $travelReimbursementRequests = [];
    private $stationPickups = [];
    private $accommodation = [];

    protected function handleInviteToSpeak(InviteToSpeak $command)
    {
        if (empty($this->name)){
            $this->fire(
                new SpeakerWasInvited(
                    $this->id(),
                    $command->getName(),
                    $command->getBio(),
                    $command->getEmail()
                )
            );
        }
    }

    protected function applySpeakerWasInvited(SpeakerWasInvited $event)
    {
        $this->email = $event->getEmail();
        $this->name = $event->getName();
        $this->bio = $event->getBio();
    }

    /**
     * This method handles an acceptation; in the event that a speaker only accepts some of the talks, the talks will
     * need to be cancelled separately using a different command/event
     *
     * @TODO add checks on this and decline method eg ignore if accepted !== null
     */
    protected function handleAcceptInvitation(AcceptInvitation $command)
    {
        $this->fire(new SpeakerAcceptedInvitation($this->id()));
    }

    protected function applySpeakerAcceptedInvitation(SpeakerAcceptedInvitation $event)
    {
        $this->accepted = true;
    }

    protected function handleDeclineInvitation(DeclineInvitation $command)
    {
        $this->fire(new SpeakerDeclinedInvitation($this->id()));
    }

    protected function applySpeakerDeclinedInvitation(SpeakerDeclinedInvitation $event)
    {
        $this->accepted = false;
    }

    /**
     * @TODO add checks here that talk exists etc
     * @TODO how to handle cancelling last/only talk (probably disallow in UI; trigger CancelAppearance instead
     */
    protected function handleCancelTalk(CancelTalk $command)
    {
        $this->fire(new TalkWasCancelled($this->id(), $command->getTalkNumber()));
    }

    protected function applyTalkWasCancelled(TalkWasCancelled $event)
    {
        unset($this->talks[$event->getTalkNumber()]);
    }

    protected function handleAddAdditionalTalk(AddAdditionalTalk $command)
    {
        $this->fire(new AdditionalTalkWasAdded($this->id(), count($this->talks), $command->getTalk()));
    }

    protected function applyAdditionalTalkWasAdded(AdditionalTalkWasAdded $event)
    {
        $this->talks[$event->getTalkId()] = $event->getTalk();
    }

    protected function handleUpdateTalk(UpdateTalk $command)
    {
        $this->fire(new TalkWasUpdated($this->id(), $command->getTalkId(), $command->getTalk()));
    }

    protected function applyTalkWasUpdated(TalkWasUpdated $event)
    {
        $this->talks[$event->getTalkId()] = $event->getTalk();
    }

    protected function handleUpdateProfile(UpdateProfile $command)
    {
        $this->fire(new ProfileWasUpdated(
            $command->getActorId(),
            $command->getName(),
            $command->getEmail(),
            $command->getBio(),
            $command->getSpecialRequirements(),
            $command->getDietaryRequirements()
        ));
    }

    protected function handleProvideJourneyDetails(ProvideJourneyDetails $command)
    {
        $this->fire(new JourneyDetailsProvided($this->id(), $command->getJourney()));
    }

    protected function applyJourneyDetailsProvided(JourneyDetailsProvided $event)
    {
        $this->journeys[] = $event->getJourney();
    }

    protected function handleRequestTravelReimbursement(RequestTravelReimbursement $command)
    {
        $reimbursementRequestId = $this->generateIdentity();

        $this->fire(new TravelReimbursementRequested($command->getSpeakerId(), $command->getAmount(), $command->getNotes(), $command->getFile(), $reimbursementRequestId));
    }

    protected function applyTravelReimbursementRequested(TravelReimbursementRequested $event)
    {
        $this->travelReimbursementRequests[$event->getReimbursementRequestId()] = self::REIMBURSEMENT_REQUESTED;
    }

    protected function handleRejectTravelReimbursement(RejectTravelReimbursement $command)
    {
        if (
            isset($this->travelReimbursementRequests[$command->getReimbursementRequestId()]) &&
            $this->travelReimbursementRequests[$command->getReimbursementRequestId()] === self::REIMBURSEMENT_REQUESTED
        ) {
            $this->fire(new TravelReimbursementRejected($command->getSpeakerId(), $command->getReimbursementRequestId(), $command->getReason()));
        }
    }

    protected function applyTravelReimbursementRejected(TravelReimbursementRejected $event)
    {
        $this->travelReimbursementRequests[$event->getReimbursementRequestId()] = self::REIMBURSEMENT_REJECTED;
    }

    protected function handleAcceptTravelReimbursement(AcceptTravelReimbursement $command)
    {
        if (
            isset($this->travelReimbursementRequests[$command->getReimbursementRequestId()]) &&
            $this->travelReimbursementRequests[$command->getReimbursementRequestId()] === self::REIMBURSEMENT_REQUESTED
        ) {
            $this->fire(new TravelReimbursementAccepted($command->getSpeakerId(), $command->getReimbursementRequestId(), $command->getNotes()));
        }
    }

    protected function applyTravelReimbursementAccepted(TravelReimbursementAccepted $event)
    {
        $this->travelReimbursementRequests[$event->getReimbursementRequestId()] = self::REIMBURSEMENT_ACCEPTED;
    }

    protected function handlePayTravelReimbursement(PayTravelReimbursement $command)
    {
        if (
            isset($this->travelReimbursementRequests[$command->getReimbursementRequestId()]) &&
            $this->travelReimbursementRequests[$command->getReimbursementRequestId()] === self::REIMBURSEMENT_ACCEPTED
        ) {
            $this->fire(new TravelReimbursementPaid($command->getSpeakerId(), $command->getReimbursementRequestId(), $command->getNotes()));
        }
    }

    protected function applyTravelReimbursementPaid(TravelReimbursementPaid $event)
    {
        $this->travelReimbursementRequests[$event->getReimbursementRequestId()] = self::REIMBURSEMENT_PAID;
    }

    protected function handleRequestStationPickup(RequestStationPickup $command)
    {
        $pickupRequestId = $this->generateIdentity();

        $this->fire(new StationPickupRequested($this->id(), $pickupRequestId, $command->getStation(), $command->getPickupTime(), $command->getNotes()));
    }

    protected function applyStationPickupRequested(StationPickupRequested $event)
    {
        $this->stationPickups[$event->getPickupRequestId()] = self::PICKUP_REQUESTED;
    }

    protected function handleAcceptStationPickupRequest(AcceptStationPickupRequest $command)
    {
        if (
            isset($this->stationPickups[$command->getPickupRequestId()]) &&
            $this->stationPickups[$command->getPickupRequestId()] === self::PICKUP_REQUESTED
        ) {
            $this->fire(new StationPickupAccepted($command->getSpeakerId(), $command->getPickupRequestId(), $command->getNotes()));
        }
    }

    protected function applyStationPickupAccepted(StationPickupAccepted $event)
    {
        $this->stationPickups[$event->getPickupRequestId()] = self::PICKUP_ACCEPTED;
    }

    protected function handleRejectStationPickupRequest(RejectStationPickupRequest $command)
    {
        if (
            isset($this->stationPickups[$command->getPickupRequestId()]) &&
            $this->stationPickups[$command->getPickupRequestId()] === self::PICKUP_REQUESTED
        ) {
            $this->fire(new StationPickupRejected($command->getSpeakerId(), $command->getPickupRequestId(), $command->getReason()));
        }
    }

    protected function applyStationPickupRejected(StationPickupRejected $event)
    {
        $this->stationPickups[$event->getPickupRequestId()] = self::PICKUP_REJECTED;
    }

    /**
     * @TODO
     * Add talk type as a string description (not editable)
     * CancelAttendance
     *
     * AccomodationRequest
     * AccomodationBooked
     * +Declined, partially booked
     *
     * SpeakerDinnerRSVP
     *
     * TicketBooked << convert to task? probably not needed inside this actor as info can be pulled into read model from external events
     * Ticket booking (on accept, update delegate info when info here changes)
     */

    protected function handleRequestAccommodation(RequestAccommodation $command)
    {
        $this->fire(new AccommodationRequested($this->id(), ...$command->getDates()));
    }

    protected function applyAccommodationRequested(AccommodationRequested $event)
    {
        foreach ($event->getDates() as $date) {
            if (!isset($this->accommodation[$date])) {
                $this->accommodation[$date] = self::ACCOMMODATION_REQUESTED;
            }
        }
    }

    protected function handleBookAccommodation(BookAccommodation $command)
    {
        $this->fire(new AccommodationBooked($this->id(), ...$command->getDates()));
    }

    protected function applyAccommodationBooked(AccommodationBooked $event)
    {
        foreach ($event->getDates() as $date) {
            if (isset($this->accommodation[$date])) {
                $this->accommodation[$date] = self::ACCOMMODATION_BOOKED;
            }
        }
    }
}