<?php

namespace ConferenceTools\Speakers\Domain\Dashboard;

use ConferenceTools\Speakers\Domain\Speaker\Event\AccommodationBooked;
use ConferenceTools\Speakers\Domain\Speaker\Event\AccommodationRequested;
use ConferenceTools\Speakers\Domain\Speaker\Event\AdditionalTalkWasAdded;
use ConferenceTools\Speakers\Domain\Speaker\Event\StationPickupAccepted;
use ConferenceTools\Speakers\Domain\Speaker\Event\StationPickupRejected;
use ConferenceTools\Speakers\Domain\Speaker\Event\StationPickupRequested;
use ConferenceTools\Speakers\Domain\Speaker\Event\TalkWasCancelled;
use ConferenceTools\Speakers\Domain\Speaker\Event\TravelReimbursementAccepted;
use ConferenceTools\Speakers\Domain\Speaker\Event\TravelReimbursementPaid;
use ConferenceTools\Speakers\Domain\Speaker\Event\TravelReimbursementRejected;
use ConferenceTools\Speakers\Domain\Speaker\Event\TravelReimbursementRequested;
use Phactor\Message\DomainMessage;
use Phactor\Message\Handler;
use Phactor\ReadModel\Repository;
use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Event\JourneyDetailsProvided;
use ConferenceTools\Speakers\Domain\Speaker\Event\ProfileWasUpdated;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerAcceptedInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerWasInvited;
use ConferenceTools\Speakers\Domain\Speaker\Event\TalkWasUpdated;

class SpeakerProjector implements Handler
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DomainMessage $domainMessage)
    {
        $message = $domainMessage->getMessage();
        switch (true) {
            case $message instanceof SpeakerWasInvited:
                $this->createSpeaker($message);
                break;
            case $message instanceof SpeakerAcceptedInvitation:
                $this->acceptInvitation($message);
                break;
            case $message instanceof AdditionalTalkWasAdded:
                $this->addTalk($message);
                break;
            case $message instanceof TalkWasUpdated:
                $this->updateTalk($message);
                break;
            case $message instanceof TalkWasCancelled:
                $this->cancelTalk($message);
                break;
            case $message instanceof ProfileWasUpdated:
                $this->updateProfile($message);
                break;
            case $message instanceof JourneyDetailsProvided:
                $this->addJourney($message);
                break;

            case $message instanceof TravelReimbursementRequested:
                $this->travelReimbursementRequested($message);
                break;
            case $message instanceof TravelReimbursementAccepted:
                $this->travelReimbursementAccepted($message);
                break;
            case $message instanceof TravelReimbursementPaid:
                $this->travelReimbursementPaid($message);
                break;
            case $message instanceof TravelReimbursementRejected:
                $this->travelReimbursementRejected($message);
                break;

            case $message instanceof StationPickupRequested:
                $this->pickupRequested($message);
                break;
            case $message instanceof StationPickupRejected:
                $this->pickupRejected($message);
                break;
            case $message instanceof StationPickupAccepted:
                $this->pickupAccepted($message);
                break;

            case $message instanceof AccommodationRequested:
                $this->accommodationRequested($message);
                break;
            case $message instanceof AccommodationBooked:
                $this->accommodationBooked($message);
        }

        $this->repository->commit();
    }

    private function fetchSpeaker(string $speakerId): Speaker
    {
        return $this->repository->get($speakerId);
    }

    private function createSpeaker(SpeakerWasInvited $message)
    {
        $speaker = new Speaker($message->getIdentity(), $message->getName(), $message->getEmail(), $message->getBio());
        $this->repository->add($speaker);
    }

    private function acceptInvitation(SpeakerAcceptedInvitation $message)
    {
        /** @var Speaker $speaker */
        $speaker = $this->repository->get($message->getIdentity());
        $speaker->accepted();
    }

    private function updateTalk(TalkWasUpdated $message)
    {
        /** @var Speaker $speaker */
        $speaker = $this->repository->get($message->getId());
        $speaker->updateTalk($message->getTalkId(), $message->getTalk());
    }

    private function updateProfile(ProfileWasUpdated $message)
    {
        /** @var Speaker $speaker */
        $speaker = $this->repository->get($message->getId());
        $speaker->updateProfile($message->getName(), $message->getEmail(), $message->getBio(), $message->getSpecialRequirements(), $message->getDietaryRequirements());
    }

    private function addJourney(JourneyDetailsProvided $message)
    {
        /** @var Speaker $speaker */
        $speaker = $this->repository->get($message->getId());
        $speaker->addJourney($message->getJourney());
    }

    private function cancelTalk(TalkWasCancelled $message)
    {
        /** @var Speaker $speaker */
        $speaker = $this->repository->get($message->getSpeakerId());
        $speaker->cancelTalk($message->getTalkNumber());
    }
    private function travelReimbursementRequested(TravelReimbursementRequested $message)
    {
        $speaker = $this->fetchSpeaker($message->getSpeakerId());
        $speaker->addTravelReimbursement($message->getReimbursementRequestId(), $message->getAmount(), $message->getNotes(), $message->getFile());
    }

    private function travelReimbursementAccepted(TravelReimbursementAccepted $message)
    {
        $speaker = $this->fetchSpeaker($message->getSpeakerId());
        $travelReimbursement = $speaker->getTravelReimbursement($message->getReimbursementRequestId());
        $travelReimbursement->accept($message->getNotes());
    }

    private function travelReimbursementRejected(TravelReimbursementRejected $message)
    {
        $speaker = $this->fetchSpeaker($message->getSpeakerId());
        $travelReimbursement = $speaker->getTravelReimbursement($message->getReimbursementRequestId());
        $travelReimbursement->reject($message->getReason());
    }

    private function travelReimbursementPaid(TravelReimbursementPaid $message)
    {
        $speaker = $this->fetchSpeaker($message->getSpeakerId());
        $travelReimbursement = $speaker->getTravelReimbursement($message->getReimbursementRequestId());
        $travelReimbursement->pay($message->getNotes());
    }

    private function pickupRequested(StationPickupRequested $message)
    {
        $speaker = $this->fetchSpeaker($message->getSpeakerId());
        $speaker->addPickupRequest($message->getPickupRequestId(), $message->getStation(), $message->getPickupTime(), $message->getNotes());
    }

    private function pickupAccepted(StationPickupAccepted $message)
    {
        $speaker = $this->fetchSpeaker($message->getSpeakerId());
        $pickupRequest = $speaker->getPickupRequest($message->getPickupRequestId());
        $pickupRequest->accept($message->getNotes());
    }

    private function pickupRejected(StationPickupRejected $message)
    {
        $speaker = $this->fetchSpeaker($message->getSpeakerId());
        $pickupRequest = $speaker->getPickupRequest($message->getPickupRequestId());
        $pickupRequest->reject($message->getReason());
    }

    private function accommodationRequested(AccommodationRequested $message)
    {
        $speaker = $this->fetchSpeaker($message->getSpeakerId());
        $speaker->accommodationRequested(...$message->getDates());
    }

    private function accommodationBooked(AccommodationBooked $message)
    {
        $speaker = $this->fetchSpeaker($message->getSpeakerId());
        $speaker->accommodationBooked(...$message->getDates());
    }

    private function addTalk(AdditionalTalkWasAdded $message)
    {
        $speaker = $this->fetchSpeaker($message->getId());
        $speaker->addTalk($message->getTalkId(), $message->getTalk());
    }
}