<?php

namespace ConferenceTools\Speakers\Controller;

use Interop\Container\ContainerInterface;
use League\Flysystem\MountManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class FileControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new FileController($container->get(MountManager::class));
    }
}