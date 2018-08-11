<?php


namespace ConferenceTools\Speakers\Domain\Task\Event;


class TaskCancelled
{
    private $id;
    private $task;

    public function __construct(string $id, string $task)
    {
        $this->id = $id;
        $this->task = $task;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTask(): string
    {
        return $this->task;
    }
}