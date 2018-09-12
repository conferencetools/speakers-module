<?php


namespace ConferenceTools\Speakers\Domain\Speaker;

use JMS\Serializer\Annotation as Jms;

class Bio
{
    /**
     * @Jms\Type("string")
     */
    private $aboutMe;
    /**
     * @Jms\Type("string")
     */
    private $twitterHandle;
    /**
     * @Jms\Type("string")
     */
    private $companyName;

    public function __construct(string $aboutMe, string $twitterHandle, string $companyName)
    {
        $this->aboutMe = $aboutMe;
        $this->twitterHandle = $twitterHandle;
        $this->companyName = $companyName;
    }

    public function getAboutMe(): string
    {
        return $this->aboutMe;
    }

    public function getTwitterHandle(): string
    {
        return $this->twitterHandle;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }
}