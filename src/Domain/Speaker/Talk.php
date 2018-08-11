<?php


namespace ConferenceTools\Speakers\Domain\Speaker;


class Talk
{
    private $title;
    private $abstract;

    public function __construct(string $title, string $abstract)
    {
        $this->title = $title;
        $this->abstract = $abstract;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAbstract(): string
    {
        return $this->abstract;
    }
}