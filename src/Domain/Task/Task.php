<?php


namespace ConferenceTools\Speakers\Domain\Task;


use Carnage\Phactor\Actor\AbstractActor;
use ConferenceTools\Speakers\Domain\Task\Command\CompleteTask;
use ConferenceTools\Speakers\Domain\Task\Event\TaskCompleted;
use ConferenceTools\Speakers\Domain\Task\Event\TaskRaised;

class Task extends AbstractActor
{
    protected $completed;
    protected $taskType;

    protected function handleCompleteTask(CompleteTask $command)
    {
        $this->fire(new TaskCompleted($this->id(), \get_class($this)));
    }

    protected function applyTaskCompleted(TaskCompleted $event)
    {
        $this->completed = true;
    }

    protected function applyTaskRaised(TaskRaised $event)
    {
        $this->taskType = $event->getTaskType();
    }
}