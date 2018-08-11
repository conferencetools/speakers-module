<?php


namespace ConferenceTools\Speakers\Domain\Speaker;


class Bio
{
    private $aboutMe;
    private $twitterHandle;
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