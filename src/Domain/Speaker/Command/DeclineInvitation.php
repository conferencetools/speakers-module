<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use Carnage\Phactor\Message\HasActorId;

class DeclineInvitation implements HasActorId
{
    private $actorId;

    public function __construct(string $actorId)
    {
        $this->actorId = $actorId;
    }

    public function getActorId(): string
    {
        return $this->actorId;
    }
}
