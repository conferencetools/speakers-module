<?php


namespace ConferenceTools\Speakers\Files;


use BsbFlysystem\Filter\File\RenameUpload;
use ConferenceTools\Speakers\Domain\File\Command\StoreFile;
use League\Flysystem\MountManager;
use Phactor\Identity\Generator;
use Phactor\Message\Bus;
use Phactor\Message\MessageFirer;

class StoreFileService
{
    private $mountManager;
    private $generator;
    private $messageBus;

    public function __construct(MountManager $mountManager, Generator $generator, MessageFirer $messageBus)
    {
        $this->mountManager = $mountManager;
        $this->generator = $generator;
        $this->messageBus = $messageBus;
    }

    public function store($uploadData, $owner): string
    {
        $prefix = 'speaker_files';
        $filesystem = $this->mountManager->getFilesystem($prefix);
        $filter = new RenameUpload(['filesystem' => $filesystem, 'use_upload_name' => true, 'randomize' => true, 'target' => '']);
        $filePath = $filter->filter($uploadData);

        $fileId = $this->generator->generateIdentity();
        $command = new StoreFile($fileId, $uploadData['name'], $prefix, $filePath['tmp_name'], $owner, 'speaker-organiser');

        $this->messageBus->fire($command);

        return $fileId;
    }
}