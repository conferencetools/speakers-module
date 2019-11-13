<?php


namespace ConferenceTools\Speakers\Domain\File\Command;


class StoreFile
{
    private $fileId;
    private $filename;
    private $filesystemIdentifier;
    private $storagePath;
    private $owner;
    private $readPrivilege;

    public function __construct(string $fileId, string $filename, string $filesystemIdentifier, string $storagePath, string $owner, string $readPrivilege)
    {
        $this->filename = $filename;
        $this->filesystemIdentifier = $filesystemIdentifier;
        $this->storagePath = $storagePath;
        $this->owner = $owner;
        $this->readPrivilege = $readPrivilege;
        $this->fileId = $fileId;
    }

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getFilesystemIdentifier(): string
    {
        return $this->filesystemIdentifier;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getReadPrivilege(): string
    {
        return $this->readPrivilege;
    }
}