<?php

namespace ConferenceTools\Speakers\Emails;

use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use Interop\Container\ContainerInterface;
use Phactor\Zend\RepositoryManager;
use Zend\Mail\Transport\Factory;
use Zend\ServiceManager\Factory\FactoryInterface;

class EmailInviteFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $transport = Factory::create($config['mail']);
        $repositoryManager = $container->get(RepositoryManager::class);

        $emailConfig = $config['conferencetools']['mailconf']['speaker-invite'] ?? [];
        $emailConfig['companyinfo'] = $config['conferencetools']['companyinfo'];
        return new EmailInvite(
            $repositoryManager->get(Speaker::class),
            $container->get('Zend\View\View'),
            $transport,
            $emailConfig
        );
    }
}
