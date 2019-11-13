<?php

namespace ConferenceTools\Speakers\Files;

use BsbFlysystem\Service\FilesystemManager;
use Interop\Container\ContainerInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use Zend\ServiceManager\Factory\FactoryInterface;

class MountManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $proxyFactory = new LazyLoadingValueHolderFactory();
        $filesystemManager = $container->get(FilesystemManager::class);
        $config = $container->get('Config');

        $mountManager = new MountManager();

        foreach ($config['bsb_flysystem']['filesystems'] as $filesystem => $_) {
            $filesystemProxy = $proxyFactory->createProxy(
                Filesystem::class,
                function (& $wrappedObject, $proxy, $method, $parameters, & $initializer) use ($filesystemManager, $filesystem) {
                    $wrappedObject = $filesystemManager->get($filesystem);
                    $initializer   = null; // turning off further lazy initialization
                }
            );

            $mountManager->mountFilesystem($filesystem, $filesystemProxy);
        }

        return $mountManager;
    }
}