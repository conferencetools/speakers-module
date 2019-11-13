<?php

namespace ConferenceTools\Speakers\Factory;

use ConferenceTools\Speakers\Domain\File\Entity\FileRecord;
use ConferenceTools\Speakers\Domain\File\FileProjector;
use Interop\Container\ContainerInterface;
use Phactor\Zend\RepositoryManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class FileProjectorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new FileProjector($container->get(RepositoryManager::class)->get(FileRecord::class));
    }
}
