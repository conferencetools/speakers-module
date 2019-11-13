<?php

namespace ConferenceTools\Speakers\Controller;

use ConferenceTools\Speakers\Files\StoreFileService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TravelControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new TravelController($container->get(StoreFileService::class));
    }
}