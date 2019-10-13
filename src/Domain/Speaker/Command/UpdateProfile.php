<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Command;

use ConferenceTools\Speakers\Domain\Speaker\DietaryRequirements;
use Phactor\Message\HasActorId;
use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use JMS\Serializer\Annotation as Jms;

class UpdateProfile implements HasActorId
{
    /**
     * @Jms\Type("string")
     */
    private $actorId;
    /**
     * @Jms\Type("string")
     */
    private $name;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Email")
     */
    private $email;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\Bio")
     */
    private $bio;
    /**
     * @Jms\Type("string")
     */
    private $specialRequirements;
    /**
     * @Jms\Type("ConferenceTools\Speakers\Domain\Speaker\DietaryRequirements")
     */
    private $dietaryRequirements;

    public function __construct(string $actorId, string $name, Email $email, Bio $bio, string $specialRequirements, DietaryRequirements $dietaryRequirements)
    {
        $this->actorId = $actorId;
        $this->name = $name;
        $this->email = $email;
        $this->bio = $bio;
        $this->specialRequirements = $specialRequirements;
        $this->dietaryRequirements = $dietaryRequirements;
    }

    public function getActorId(): string
    {
        return $this->actorId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getBio(): Bio
    {
        return $this->bio;
    }

    public function getSpecialRequirements(): string
    {
        return $this->specialRequirements;
    }

    public function getDietaryRequirements(): DietaryRequirements
    {
        return $this->dietaryRequirements;
    }
}