<?php

namespace ConferenceTools\Speakers\Files;

use Interop\Container\ContainerInterface;
use League\Flysystem\MountManager;
use Phactor\Identity\Generator;
use Phactor\Message\Bus;
use Phactor\Message\MessageFirer;
use Zend\ServiceManager\Factory\FactoryInterface;

class StoreFileServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $messageBus = $container->get(Bus::class);
        $identityGenerator = $container->get(Generator::class);

        return new StoreFileService($container->get(MountManager::class), $identityGenerator, new MessageFirer($identityGenerator, $messageBus));
    }
}