<?php


namespace ConferenceTools\Speakers\Domain\File;


use ConferenceTools\Speakers\Domain\File\Command\StoreFile;
use ConferenceTools\Speakers\Domain\File\Entity\FileRecord;
use Phactor\Identity\Generator;
use Phactor\Message\DomainMessage;
use Phactor\Message\Handler;
use Phactor\ReadModel\Repository;

class FileProjector implements Handler
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DomainMessage $message)
    {
        $command  = $message->getMessage();
        if (!($command instanceof StoreFile)) {
            return;
        }

        $entity = new FileRecord(
            $command->getFileId(),
            $command->getFilename(),
            $command->getFilesystemIdentifier(),
            $command->getStoragePath(),
            $command->getOwner(),
            $command->getReadPrivilege()
        );

        $this->repository->add($entity);
    }
}