<?php

namespace ConferenceTools\Speakers\Domain\Dashboard;

use ConferenceTools\Speakers\Domain\Speaker\Event\TalkWasCancelled;
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
        }

        $this->repository->commit();
    }

    private function createSpeaker(SpeakerWasInvited $message)
    {
        $speaker = new Speaker($message->getIdentity(), $message->getName(), $message->getEmail(), $message->getBio());
        foreach ($message->getTalks() as $index => $talk) {
            $speaker->addTalk($index, $talk);
        }
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
}