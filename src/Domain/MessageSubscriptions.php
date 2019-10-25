<?php

namespace ConferenceTools\Speakers\Domain;

use ConferenceTools\Speakers\Domain\Dashboard\SpeakerProjector;
use ConferenceTools\Speakers\Domain\Speaker\Command as SpeakerCommand;
use ConferenceTools\Speakers\Domain\Speaker\Event as SpeakerEvent;
use ConferenceTools\Speakers\Domain\Task\ClearTaskHandler;
use ConferenceTools\Speakers\Domain\Task\Command as TaskCommand;
use ConferenceTools\Speakers\Domain\Task\Event as TaskEvent;
use ConferenceTools\Speakers\Domain\Speaker\Speaker;
use ConferenceTools\Speakers\Domain\Task\UpdateWebsite;

class MessageSubscriptions
{
    public static function getSubscriptions()
    {
        return [
            SpeakerCommand\AcceptInvitation::class => [
                Speaker::class,
            ],
            SpeakerCommand\DeclineInvitation::class => [
                Speaker::class,
            ],
            SpeakerCommand\InviteToSpeak::class => [
                Speaker::class,
            ],
            SpeakerCommand\CancelTalk::class => [
                Speaker::class,
            ],
            SpeakerCommand\AddAdditionalTalk::class => [
                Speaker::class,
            ],
            SpeakerCommand\UpdateTalk::class => [
                Speaker::class,
            ],
            SpeakerCommand\UpdateProfile::class => [
                Speaker::class,
            ],
            SpeakerCommand\ProvideJourneyDetails::class => [
                Speaker::class,
            ],
            SpeakerCommand\RejectTravelReimbursement::class => [
                Speaker::class,
            ],
            SpeakerCommand\RequestTravelReimbursement::class => [
                Speaker::class,
            ],
            SpeakerCommand\AcceptTravelReimbursement::class => [
                Speaker::class,
            ],
            SpeakerCommand\PayTravelReimbursement::class => [
                Speaker::class,
            ],
            SpeakerCommand\RequestStationPickup::class => [
                Speaker::class,
            ],
            SpeakerCommand\AcceptStationPickupRequest::class => [
                Speaker::class,
            ],
            SpeakerCommand\RejectStationPickupRequest::class => [
                Speaker::class,
            ],
            SpeakerCommand\RequestAccommodation::class => [
                Speaker::class,
            ],
            SpeakerCommand\BookAccommodation::class => [
                Speaker::class,
            ],


            SpeakerEvent\SpeakerWasInvited::class => [
                UpdateWebsite::class,
                SpeakerProjector::class,
            ],
            SpeakerEvent\SpeakerAcceptedInvitation::class => [
                UpdateWebsite::class,
                SpeakerProjector::class,
            ],
            SpeakerEvent\SpeakerDeclinedInvitation::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\ProfileWasUpdated::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\TalkWasUpdated::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\TalkWasCancelled::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\JourneyDetailsProvided::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\TravelReimbursementRequested::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\TravelReimbursementRejected::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\TravelReimbursementAccepted::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\TravelReimbursementPaid::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\StationPickupRequested::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\StationPickupAccepted::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\StationPickupRejected::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\AccommodationBooked::class => [
                SpeakerProjector::class,
            ],
            SpeakerEvent\AccommodationRequested::class => [
                SpeakerProjector::class,
            ],


            TaskCommand\CompleteTask::class => [
                ClearTaskHandler::class,
            ],

            TaskEvent\TaskRaised::class => [],
        ];
    }
}