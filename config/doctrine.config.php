<?php
return [
    'driver' => [
        'dashboard' => [
            'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
            'cache' => 'array',
            'paths' => [__DIR__ . '/../src/Domain/Dashboard/Entity']
        ],
        'files' => [
            'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
            'cache' => 'array',
            'paths' => [__DIR__ . '/../src/Domain/File/Entity'],
        ],
        'orm_default' => [
            'drivers' => [
                'ConferenceTools\\Speakers\\Domain\\Dashboard\\Entity' => 'dashboard',
                'ConferenceTools\\Speakers\\Domain\\File\\Entity' => 'files',
            ]
        ]
    ],
];
