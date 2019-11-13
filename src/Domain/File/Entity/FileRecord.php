<?php

namespace ConferenceTools\Speakers\Domain\File\Entity;

use Doctrine\ORM\Mapping as ORM;
use Phactor\Auth\User;

/** @ORM\Entity() */
class FileRecord
{
    /** @ORM\Id() @ORM\Column(type="string") */
    private $id;
    /** @ORM\Column(type="string") */
    private $filename;
    /** @ORM\Column(type="string") */
    private $filesystemIdentifier;
    /** @ORM\Column(type="string") */
    private $storagePath;
    /** @ORM\Column(type="string") */
    private $owner;
    /** @ORM\Column(type="string") */
    private $readPrivilege;

    public function __construct(string $id, string $filename, string $filesystemIdentifier, string $storagePath, string $owner, string $readPrivilege)
    {
        $this->id = $id;
        $this->filename = $filename;
        $this->filesystemIdentifier = $filesystemIdentifier;
        $this->storagePath = $storagePath;
        $this->owner = $owner;
        $this->readPrivilege = $readPrivilege;
    }

    public function canAccess(User $user)
    {
        return $user->getId() === $this->owner || $user->isGranted($this->readPrivilege);
    }

    public function getId(): string
    {
        return $this->id;
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
}