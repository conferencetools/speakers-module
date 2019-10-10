<?php


namespace ConferenceTools\Speakers\Domain\Task;


use Phactor\Message\ActorIdentity;
use Phactor\Message\DomainMessage;
use Phactor\Message\Handler;
use Phactor\Persistence\ActorRepository;
use ConferenceTools\Speakers\Domain\Task\Command\CompleteTask;

class ClearTaskHandler implements Handler
{
    private $actorRepository;

    public function __construct(ActorRepository $actorRepository)
    {
        $this->actorRepository = $actorRepository;
    }

    public function handle(DomainMessage $domainMessage)
    {
        $message = $domainMessage->getMessage();
        if (!($message instanceof CompleteTask)) {
            return;
        }

        /** @var Task $task */
        $task = $this->actorRepository->load(new ActorIdentity($message->getTask(), $message->getTaskId()));
        $task->handle($domainMessage);
        $this->actorRepository->save($task);
    }
}