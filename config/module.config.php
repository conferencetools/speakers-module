<?php

return [
    'auth' => [
        'permissions' => [
            'speaker' => 'Can edit own speaker info',
            'speaker-organiser' => 'Can manage all speakers',
        ],
        'redirects' => [
            'byPermission' => [
                'speaker' => 'speakers/dashboard'
            ]
        ]
    ],
    'bsb_flysystem' => [
        'filesystems' => [
            'speaker_files' => [
                'adapter' => 'speaker_files',
                'cache' => false,
                'eventable' => false,
            ],
        ],
    ],
    'controllers' => require __DIR__ . '/controllers.config.php',
    'controller_plugins' => [
        'invokables' => [
            'currentSpeaker' => \ConferenceTools\Speakers\Mvc\Controller\Plugin\CurrentSpeaker::class,
        ],
    ],
    'doctrine' => require __DIR__ . '/doctrine.config.php',
    'message_handlers' => require __DIR__ . '/message_handlers.config.php',
    'message_subscriptions' => \ConferenceTools\Speakers\Domain\MessageSubscriptions::getSubscriptions(),
    'navigation' => require __DIR__ . '/navigation.config.php',
    'router' => [
        'routes' => require __DIR__ . '/routes.config.php',
    ],
    'view_manager' => [
        'controller_map' => [
            'ConferenceTools\Speakers\Controller' => 'speakers',
        ],
        'template_map' => require __DIR__ . '/views.config.php',
    ],

    'service_manager' => [
        'factories' => [
            \League\Flysystem\MountManager::class => \ConferenceTools\Speakers\Files\MountManagerFactory::class,
            \ConferenceTools\Speakers\Files\StoreFileService::class => \ConferenceTools\Speakers\Files\StoreFileServiceFactory::class,
        ]
    ]
];