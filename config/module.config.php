<?php

return [
    'controllers' => require __DIR__ . '/controllers.config.php',
    'router' => [
        'routes' => require __DIR__ . '/routes.config.php',
    ],
    'view_manager' => [
        'controller_map' => [
            'ConferenceTools\Speakers\Controller' => 'speakers',
        ],
        'template_map' => require __DIR__ . '/views.config.php',
    ],
    'message_subscriptions' => \ConferenceTools\Speakers\Domain\MessageSubscriptions::getSubscriptions()
];