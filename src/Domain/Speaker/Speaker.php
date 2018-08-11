<?php

namespace ConferenceTools\Speakers\Domain\Speaker;

use Carnage\Phactor\Actor\AbstractActor;
use ConferenceTools\Speakers\Domain\Speaker\Command\AcceptInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Command\AddAdditionalTalk;
use ConferenceTools\Speakers\Domain\Speaker\Command\CancelTalk;
use ConferenceTools\Speakers\Domain\Speaker\Command\DeclineInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Command\InviteToSpeak;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateTalk;
use ConferenceTools\Speakers\Domain\Speaker\Event\AdditionalTalkWasAdded;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerAcceptedInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerDeclinedInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerWasInvited;
use ConferenceTools\Speakers\Domain\Speaker\Event\TalkWasCancelled;
use ConferenceTools\Speakers\Domain\Speaker\Event\TalkWasUpdated;

class Speaker extends AbstractActor
{
    private $email;
    private $name;
    private $talks;
    private $bio;
    private $accepted;

    protected function handleInvitedToSpeak(InviteToSpeak $command)
    {
        if (empty($this->name)){
            $this->fire(
                new SpeakerWasInvited(
                    $this->id(),
                    $command->getName(),
                    $command->getBio(),
                    $command->getEmail(),
                    ... $command->getTalks()
                )
            );
        }
    }

    protected function applySpeakerWasInvited(SpeakerWasInvited $event)
    {
        $this->email = $event->getEmail();
        $this->name = $event->getName();
        $this->bio = $event->getBio();
        $this->talks = $event->getTalks();
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

    /**
     * @TODO
     *
     * CancelAttendance
     * UpdateProfile (if linked ticket; update that too?)
     *
     * AccomodationRequest
     * AccomodationBooked
     * +Declined, partially booked
     *
     * TravelDetailsProvided
     * TravelReimbursementRequest
     * TravelReimbursementSent
     * TravelReimbursementDeclined
     * TravelReimbursementPartiallySent
     *
     * SpeakerDinnerRSVP
     *
     * TicketBooked << convert to task? probably not needed inside this actor as info can be pulled into read model from external events
     */
}