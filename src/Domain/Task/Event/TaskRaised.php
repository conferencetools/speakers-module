<?php


namespace ConferenceTools\Speakers\Domain\Task\Event;


class TaskRaised
{
    private $id;
    private $taskCategory;
    private $description;
    private $taskType;

    public function __construct(string $id, string $taskCategory, string $taskType, string $description)
    {
        $this->id = $id;
        $this->taskCategory = $taskCategory;
        $this->description = $description;
        $this->taskType = $taskType;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTaskCategory(): string
    {
        return $this->taskCategory;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTaskType(): string
    {
        return $this->taskType;
    }
}