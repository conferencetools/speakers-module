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
            SpeakerEvent\TalkWasCancelled::class => [],
            SpeakerEvent\JourneyDetailsProvided::class => [
                SpeakerProjector::class,
            ],

            TaskCommand\CompleteTask::class => [
                ClearTaskHandler::class,
            ],

            TaskEvent\TaskRaised::class => [],
        ];
    }
}