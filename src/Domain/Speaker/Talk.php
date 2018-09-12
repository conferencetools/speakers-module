<?php


namespace ConferenceTools\Speakers\Domain\Speaker;

use JMS\Serializer\Annotation as Jms;

class Talk
{
    /**
     * @Jms\Type("string")
     */
    private $title;
    /**
     * @Jms\Type("string")
     */
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