<?php


namespace ConferenceTools\Speakers\Domain\Task\Command;


class CompleteTask
{
    private $taskId;
    private $task;

    public function __construct(string $taskId, string $task)
    {
        $this->taskId = $taskId;
        $this->task = $task;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }

    public function getTask(): string
    {
        return $this->task;
    }
}
