<?php

namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use Carnage\Phactor\Message\HasActorId;
use JMS\Serializer\Annotation as Jms;

class DeclineInvitation implements HasActorId
{
    /**
     * @Jms\Type("string")
     */
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
