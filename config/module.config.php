<?php

return [
    'controllers' => require __DIR__ . '/controllers.config.php',
    'doctrine' => require __DIR__ . '/doctrine.config.php',
    'message_handlers' => require __DIR__ . '/message_handlers.config.php',
    'message_subscriptions' => \ConferenceTools\Speakers\Domain\MessageSubscriptions::getSubscriptions(),
    'router' => [
        'routes' => require __DIR__ . '/routes.config.php',
    ],
    'view_manager' => [
        'controller_map' => [
            'ConferenceTools\Speakers\Controller' => 'speakers',
        ],
        'template_map' => require __DIR__ . '/views.config.php',
    ],
];