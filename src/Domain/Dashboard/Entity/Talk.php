<?php


namespace ConferenceTools\Speakers\Domain\Dashboard\Entity;

use Doctrine\ORM\Mapping as ORM;
use ConferenceTools\Speakers\Domain\Speaker\Talk as TalkVO;

/**
 * @ORM\Entity()
 */
class Talk
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker", inversedBy="talks")
     * @ORM\JoinColumn(name="speaker_id", referencedColumnName="identity")
     */
    private $speaker;
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer", name="idx")
     */
    private $index;
    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $abstract;

    public function __construct(Speaker $speaker, int $index, TalkVO $talk)
    {
        $this->speaker = $speaker;
        $this->index = $index;
        $this->title = $talk->getTitle();
        $this->abstract = $talk->getAbstract();
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAbstract()
    {
        return $this->abstract;
    }

    public function update(string $title, string $abstract)
    {
        $this->title = $title;
        $this->abstract = $abstract;
    }
}