<?php


namespace ConferenceTools\Speakers\Domain\Speaker\Event;

use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\DietaryRequirements;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use JMS\Serializer\Annotation as Jms;

class ProfileWasUpdated
{
    /**
     * @Jms\Type("string")
     */
    private $id;
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

    public function __construct(string $id, string $name, Email $email, Bio $bio, string $specialRequirements, DietaryRequirements $dietaryRequirements)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->bio = $bio;
        $this->specialRequirements = $specialRequirements;
        $this->dietaryRequirements = $dietaryRequirements;
    }

    public function getId(): string
    {
        return $this->id;
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