<?php

namespace ConferenceTools\Speakers\Domain\Task;

use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerAcceptedInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerWasInvited;
use ConferenceTools\Speakers\Domain\Speaker\Event\TalkWasCancelled;
use ConferenceTools\Speakers\Domain\Task\Event\TaskCancelled;
use ConferenceTools\Speakers\Domain\Task\Event\TaskRaised;

class UpdateWebsite extends Task
{
    const TASK_TYPE_ADD_SPEAKER_TO_WEBSITE = 'task-type-add-speaker-to-website';
    const TASK_TYPE_REMOVE_TALK_FROM_WEBSITE = 'task-type-remove-talk-from-website';

    protected function handleSpeakerAcceptedInvitation(SpeakerAcceptedInvitation $event)
    {
        //@TODO populate description with speaker information
        $description = '';
        $this->fire(new TaskRaised($this->id(), \get_class($this), self::TASK_TYPE_ADD_SPEAKER_TO_WEBSITE, $description));
    }

    protected function applySpeakerWasInvited(SpeakerWasInvited $event)
    {
        //@TODO capture speaker information
    }

    protected function handleTalkWasCancelled(TalkWasCancelled $command)
    {
        //@todo There are a lot of edge cases here which need to be handled
        switch(true) {
            case ($this->completed === false && $this->taskType === self::TASK_TYPE_ADD_SPEAKER_TO_WEBSITE):
                $this->fire(new TaskCancelled($this->id(), \get_class($this)));
                $description = '';
                $this->fire(new TaskRaised($this->id(), \get_class($this), self::TASK_TYPE_ADD_SPEAKER_TO_WEBSITE, $description));
                break;
            default:
                $description = '';
                $this->fire(new TaskRaised($this->id(), \get_class($this), self::TASK_TYPE_REMOVE_TALK_FROM_WEBSITE, $description));
        }
    }
}

/**
 * @TODO
 *
 * Populate descriptions
 *
 * Update Talk
 * Add Talk
 *
 * Update Bio
 *
 */