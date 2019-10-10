<?php

namespace ConferenceTools\Speakers\Factory;

use Phactor\Zend\RepositoryManager;
use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Dashboard\SpeakerProjector;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class SpeakerProjectorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SpeakerProjector($container->get(RepositoryManager::class)->get(Speaker::class));
    }
}
