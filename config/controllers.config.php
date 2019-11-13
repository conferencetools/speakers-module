<?php

use ConferenceTools\Speakers\Controller;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'factories' => [
        Controller\Admin\ImportController::class => InvokableFactory::class,
        Controller\Admin\SpeakerController::class => InvokableFactory::class,
        Controller\Admin\TalkController::class => InvokableFactory::class,
        Controller\Admin\TravelReimbursementController::class => InvokableFactory::class,
        Controller\Admin\StationPickupController::class => InvokableFactory::class,
        Controller\Admin\HotelController::class => InvokableFactory::class,
        Controller\DashboardController::class => InvokableFactory::class,
        Controller\InvitationController::class => InvokableFactory::class,
        Controller\ProfileController::class => InvokableFactory::class,
        Controller\TalkController::class => InvokableFactory::class,
        Controller\TravelController::class => Controller\TravelControllerFactory::class,
        Controller\HotelController::class => InvokableFactory::class,
        Controller\FileController::class => Controller\FileControllerFactory::class,
    ]
];