<?php

namespace ConferenceTools\Speakers\Controller;

use ConferenceTools\Speakers\Domain\File\Entity\FileRecord;
use League\Flysystem\Adapter\Local;
use League\Flysystem\MountManager;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;
use Zend\Http\PhpEnvironment\Response;
use Zend\Uri\Uri;

class FileController extends AppController
{
    const NGINX_VIRTUAL_LOCATION = '/private-files/';
    /** @var MountManager */
    private $mountManager;

    public function __construct(MountManager $mountManager)
    {
        $this->mountManager = $mountManager;
    }

    public function downloadAction()
    {
        $fileId = $this->params()->fromRoute('fileId');
        /** @var FileRecord $fileRecord */
        $fileRecord = $this->repository(FileRecord::class)->get($fileId);

        $filesystem = $this->mountManager->getFilesystem($fileRecord->getFilesystemIdentifier());
        $adapter = $filesystem->getAdapter();

        switch (true) {
            case $adapter instanceof Local:
                /*
                    if it's locally stored, we assume we have nginx setup with something like
                    location /private-files/ {
                        root /var/www/data/files;
                        internal;
                    }
                    storage path in file record will be relative to the nginx root, so we need to prefix with the virtual location
                    this is hard coded for now.
                */
                $fileLocation = self::NGINX_VIRTUAL_LOCATION . $fileRecord->getStoragePath();
                break;
            case $adapter instanceof  GoogleStorageAdapter:
                /*
                    if file is stored in a google cloud bucket, we assume the bucket name is part of the uri,
                    path is prefixed with NGINX_VIRTUAL_LOCATION and nginx is setup to proxy that location to
                    google cloud storage
                */
                $signedUri = $adapter->getTemporaryUrl($fileRecord->getStoragePath(), (new \DateTimeImmutable())->add(new \DateInterval('PT15M')));

                $uri = new Uri($signedUri);
                $fileLocation = self::NGINX_VIRTUAL_LOCATION . $uri->getPath() . '?' .$uri->getQuery();
                break;
            default:
                throw new \Exception('Unable to determine file location');

        }

        /** @var Response $response */
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('X-Accel-Redirect: ' . $fileLocation);
        $response->getHeaders()->addHeaderLine('Content-Type: ');
        $response->getHeaders()->addHeaderLine('Content-Length: ');
        return $response;
    }
}