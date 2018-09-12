<?php

use ConferenceTools\Speakers\Controller;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'factories' => [
        Controller\DashboardController::class => InvokableFactory::class,
        Controller\ImportController::class => InvokableFactory::class,
        Controller\InvitationController::class => InvokableFactory::class,
        Controller\ProfileController::class => InvokableFactory::class,
        Controller\TalkController::class => InvokableFactory::class,
    ]
];